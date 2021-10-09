<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Mail\adminWithdrawal;
use App\Mail\investorWithdrawal;
use Illuminate\Support\Facades\Mail;

class WithdrawalController extends Controller
{
    
    public function index()
    {
        $count = 1;
        if(auth()->user()->user_types == 2 || auth()->user()->user_types == 3){
            $withdrawals = Withdrawal::with('user')->get();
            
            return view('backend.admin.withdrawals.index', compact('withdrawals', 'count'));
        }

        if(auth()->user()->user_types == 1 ){

            $withdrawals = Withdrawal::with('user')->whereUserId(auth()->user()->id)->get();

            $minimum = Setting::select('payment_delay')->first()->value('payment_delay');

            return view('backend.user.withdrawals', compact('minimum', 'withdrawals', 'count'));
        } 
    }

    public function create()
    {
        $commission = (auth()->user()->plans->commission /100) * auth()->user()->wallet_balance;
        $available_in_wallet =  auth()->user()->wallet_balance - $commission;

        return view('backend.user.createwithdrawal', compact('available_in_wallet'));
    }

    public function store(Request $request)
    {
        $commission = auth()->user()->plans->commission;
        $max_commission = ($commission /100) * auth()->user()->wallet_balance;
        $max_withdrawal =  auth()->user()->wallet_balance - $max_commission;

        if($request->wallet == 'wallet'){
            if($request->amount > $max_withdrawal){
                return back()->with('error', 'Trying to cheat? Maximum amount you can withdraw from your wallet is: $'.$max_withdrawal);
            }

            //Check if User has withdrawn from main wallet this month
            $monthly_withdraw_history = auth()->user()->withdraw();
            if($monthly_withdraw_history > 0){
                return back()->with('error', 'You can only make withdrawal from your main wallet once every 30 days');
            }
            //End of check
                      

            $withdrawal_commision = ($commission / 100) * $request->amount;
            $amount = $request->amount - $withdrawal_commision;

            auth()->user()->wallet_balance =  auth()->user()->wallet_balance - ($amount + $withdrawal_commision);
            auth()->user()->save();

        }

        if($request->wallet == 'referral'){
            if( auth()->user()->referral_wallet_balance < $request->amount){
                return back()->with('error', 'Maximum amount you can withdraw from your referral earnings  is: $'.auth()->user()->referral_wallet_balance);
            }

            $withdrawal_commision = 0;
            auth()->user()->referral_wallet_balance =  auth()->user()->referral_wallet_balance - $request->amount;
            auth()->user()->save();

        }

        if($request->wallet == 'medal'){
            if( auth()->user()->medals_wallet_balance < $request->amount){
                return back()->with('error', 'Maximum amount you can withdraw from your medal earnings  is: $'.auth()->user()->medals_wallet_balance);
            }

            $withdrawal_commision = 0;

            auth()->user()->medals_wallet_balance =  auth()->user()->medals_wallet_balance - $request->amount;
            auth()->user()->save();

        }
           
        $withdrawal = Withdrawal::create([
            'amount' => $request->amount-$withdrawal_commision,
            'user_id' => auth()->user()->id,
            'wallet_type' => $request->wallet,
            'commission' => $withdrawal_commision,
        ]);
        
        $user = auth()->user();

        Mail::to(Setting::select('official_mail')->first()->value('official_mail'))->send(new adminWithdrawal($user, $withdrawal));

        Mail::to(auth()->user()->email)->send(new investorWithdrawal($user, $withdrawal));


        $count = 1;
        return redirect(route('withdraw.index'))->with('message', 'Request sent successfully, you can check the status of your request here')->with('count', $count);
            
    }

    public function show(Withdrawal $withdrawal)
    {
        
    }

    public function edit(Withdrawal $withdrawal, $id)
    {
        $withdrawal = Withdrawal::with('user')->findorfail($id);

        return view('backend.admin.withdrawals.update', compact('withdrawal'));
         
    }

    public function update(Request $request, Withdrawal $withdrawal, $id)
    {

        if(auth()->user()->user_types == 2 || auth()->user()->user_types == 3){
            $withdrawal = Withdrawal::findorfail($id);
          
            if($request->date_paid == $withdrawal->date_paid){
                $withdrawal->date_paid = $withdrawal->date_paid;
            }

            if($request->paid == 1){
                $withdrawal->date_paid = date('Y-m-d');
            }

            if($request->paid == 0){
                $withdrawal->date_paid = NULL;
            }

            $withdrawal->paid = $request->paid;
           
            $withdrawal->save();

            
            return redirect(route('withdraw.index'))->with('message', 'Update successful');
        }
    }

    public function deleteWithdrawal($id)
    {

        $withdrawal = Withdrawal::findorfail($id);

        if(auth()->user()->user_types == 2 || auth()->user()->user_types == 3){
           
            if($withdrawal->wallet_type == 'wallet'){
                $withdrawal->user()->update([
                    'wallet_balance' => $withdrawal->user->wallet_balance + $withdrawal->amount + $withdrawal->commission,
                ]);
            }

            if($withdrawal->wallet_type == 'referral'){
                $withdrawal->user()->update([
                    'referral_wallet_balance' => $withdrawal->user->referral_wallet_balance + $withdrawal->amount + $withdrawal->commission,
                ]);
            }
            
            if($withdrawal->wallet_type == 'medal'){
                $withdrawal->user()->update([
                    'medals_wallet_balance' => $withdrawal->user->medals_wallet_balance + $withdrawal->amount + $withdrawal->commission,
                ]);
            }
            
            $withdrawal->delete();

            return back()->with('message', 'Delete Successful, Investor wallet has been updated');

        }

        if(auth()->user()->user_types == 1){

            if($withdrawal->user_id <> auth()->user()->id){
                return redirect(route('withdraw.index'))->with('error', 'looks like you hit a wrong button. Please try again');
            }

            if($withdrawal->paid == 1){
                return redirect(route('withdraw.index'))->with('error', 'looks like you have been paid for this withdrawal entry. Please write support');
            }
            
            if($withdrawal->wallet_type == 'wallet'){
                $withdrawal->user()->update([
                    'wallet_balance' => $withdrawal->user->wallet_balance + $withdrawal->amount + $withdrawal->commission,
                ]);
            }

            if($withdrawal->wallet_type == 'referral'){
                $withdrawal->user()->update([
                    'referral_wallet_balance' => $withdrawal->user->referral_wallet_balance + $withdrawal->amount + $withdrawal->commission,
                ]);
            }
            
            if($withdrawal->wallet_type == 'medal'){
                $withdrawal->user()->update([
                    'medals_wallet_balance' => $withdrawal->user->medals_wallet_balance + $withdrawal->amount + $withdrawal->commission,
                ]);
            }

            $withdrawal->delete();

            return back()->with('message', 'Delete Successful, Your wallet has been updated');
        }
    }
}
