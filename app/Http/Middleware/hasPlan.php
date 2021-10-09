<?php

namespace App\Http\Middleware;

use auth;
use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use App\Models\Transaction;
use App\Mail\paymentComplete;
use App\Models\publishing_plans;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class hasPlan extends Controller
{

    public function handle($request, Closure $next)
    {
        if (Auth::check()){
                //Check payments for user payments and add value where applicable
                $jsonresponse = json_decode(Controller::getCharges(), true);
                
                //Get all user payment
                $userPayments = Transaction::whereUserId(auth()->user()->id)->get()->toArray();
                $userPayments = array_merge_recursive(array_column($userPayments, 'reference'));

                $allPayments = collect($jsonresponse['data'], true)
                    ->whereNotIn('id',  $userPayments)->where('payments', '!=', null)->whereNotIn('id', $userPayments)
                    ->filter(function($allPayments){
                    if(strtolower($allPayments['metadata']['email']) == strtolower(auth()->user()->email) && $allPayments['payments'][0]['status'] === 'CONFIRMED'){
                        return $allPayments;
                    }
                });
                
                if($allPayments->count() > 0){
                    //if user plan has expiry, user is trying to select another plan
                    if(!is_null(auth()->user()->plan_expiry)){
                        //Get payment made after user plan expiry
                        $allPayments = $allPayments->where('confirmed_at', '>', auth()->user()->plan_expiry);
                        
                        $payment = $allPayments->first();
                        if(!is_null($payment)){
                            // dd($payment);
                            // dd('sdd');
                            $plan = publishing_plans::where('title', $payment['name'])->first();
                            $this->processTransaction($plan, $payment);

                        }
                       
                    }else{
                        //This user has never paid, process payment
                        $payment = $allPayments->first();
                        if(!is_null($payment)){
                            // dd('new');
                            $plan = publishing_plans::where('title', $payment['name'])->first();
                            $this->processTransaction($plan, $payment);
                        }
                        
                    }
                    //if plan has expired
                    if(!is_null(auth()->user()->plan_expiry && Carbon::parse(auth()->user()->plan_expiry) < Carbon::now())){
                        //Get payment made after user plan expiry
                        $allPayments = $allPayments->where('confirmed_at', '>', auth()->user()->plan_expiry);
                        
                        $payment = $allPayments->first();
                        if(!is_null($payment)){
                            // dd('expired');
                            $plan = publishing_plans::where('title', $payment['name'])->first();
                            $this->processTransaction($plan, $payment);
                        }
                    }
                }
                
            //check if user has no plan
            if (is_null(auth()->user()->plans) && auth()->user()->user_types == 1 ) {
                $title = 'Purchase plan';
                
                return redirect(url('/selectplans'));
            }

            if (Carbon::parse(auth()->user()->plan_expiry) < Carbon::now() && auth()->user()->user_types == 1 ) {
            auth()->user()->medals()->detach();
                $title = 'Renew';
                return redirect(url('/renewplan'));
            }
        }
        
        return $next($request);
    }

    private function processTransaction($plan, $payment){
        if($payment['payments'][0]['value']['local']['amount'] > $plan->amount ) {
            auth()->user()->wallet_balance = auth()->user()->wallet_balance + ($payment['payments'][0]['value']['local']['amount'] - $plan->amount);
        }elseif($payment['payments'][0]['value']['local']['amount'] == $plan->amount){
            auth()->user()->publishing_plans_id = $plan->id;
            auth()->user()->plan_expiry = Carbon::parse($payment['confirmed_at'])->addMonth(1);
            auth()->user()->save();

        }else{
            //Silence is golden
        }

        //Update rreferal plan
        Controller::updateReferral($plan); 
        //Create transaction log
        Controller::createTransactionLog(auth()->user()->id, $payment['id'], $payment['payments'][0]['value']['local']['amount'], $payment['payments'][0]['status'], $payment['description'], json_encode($payment)); 
        
        Mail::to(auth()->user()->email)->send(new paymentComplete(auth()->user(), $payment['name'], $payment['payments'][0]['value']['local']['amount']));

        Mail::to(Setting::select('official_mail')->first()->value('official_mail'))->send(new paymentComplete(auth()->user(), $payment['name'], $payment['payments'][0]['value']['local']['amount']));
    }
}
