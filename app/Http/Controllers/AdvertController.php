<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Advert;
use App\Models\Setting;
use App\Mail\generalEmail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AdvertController extends Controller
{
    public function __construct(){
        $this->middleware(['verified', 'auth', 'hasPlan'])->only(['create', 'edit', 'update', 'processPayment']);
        $this->middleware(['admin'])->only(['approveAdvert']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_types != 1 ){
            $adverts = Advert::with('task')->get();
            
            return view('backend.admin.adverts.index', compact('adverts'));
        }

        if(auth()->user()->user_types == 1 ){
            $allPayments = collect(auth()->user()->transactions->where('type', 3)->where('status', 'PENDING'));
           
            if($allPayments){
                
                 //loop through all payments and deliver value
                foreach($allPayments as $payment){
                    // print_r($payment);
                   
                        $transactionDetails = collect($this->getTransactionDetails($payment->reference));
              
                        if(isset($transactionDetails['payments'][0]) && $transactionDetails['payments'][0]['status'] == 'CONFIRMED'){
                          
                            $name = $transactionDetails['name'];

                            $percentage_bonus = !is_null(Setting::first()->value('advert_referral_percent')) ? ((double) Setting::first()->value('advert_referral_percent')/100) * $transactionDetails['payments'][0]['value']['local']['amount'] : 0;
      
                            $this->processAdvertPayments($name, $payment->amount, $transactionDetails['payments'][0]['value']['local']['amount'], 2, $payment->reference, $percentage_bonus, $transactionDetails);
                                                       
                        }
                    
                }
                   
            }
               
            $adverts = Advert::whereUserId(auth()->user()->id)->latest()->get();

            return view('backend.user.adverts', compact('adverts'));
        }
        
        return view('backend.user.adverts', compact('adverts'));
    
    }

    public function processAdvertPayments($purpose, $price, $amount_paid, $type, $payment_id, $percentage_bonus, $payment){
 
        if(!is_null($price) && ($amount_paid == $price)){
            $this->createAdvertSlot($amount_paid, $payment_id, 'Coinbase', $payment);
            $this->updateUplineOnAdvertDesignPayment($percentage_bonus);
            $this->sendAdvertDesignEmail($payment_id, 'advert_payment_received', $amount_paid, $purpose, $payment_id);
        }

        // If amount paid is over
        if(!is_null($price) && ($amount_paid > $price)){
            $balance = $amount_paid - $price;
            auth()->user()->update([
                'wallet_balance' => $balance,
            ]);
            
            $this->createAdvertSlot($amount_paid, $payment_id, 'Coinbase', $payment);
            $this->updateUplineOnAdvertDesignPayment($percentage_bonus);
            $this->sendAdvertDesignEmail($payment_id, 'over_payment_received_for_advert', $amount_paid, $purpose, $balance, $payment_id);
        }
        
        // If underpayment
        if(!is_null($price) && ($amount_paid < $price)){
            $balance = $price - $amount_paid;
            $this->sendAdvertDesignEmail($payment_id, 'under_payment_received_for_advert', $amount_paid, $purpose, $balance, $price, $payment_id);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.createadvert');
    }

    public function processPayment(Request $request){
        // auth()->user()->referral_wallet_balance
        if($request->has('payment_method') && $request->payment_method == 'wallet'){
            if(auth()->user()->wallet_balance < Setting::first()->value('advert_price')){
                return back()->with('error', 'Not enough funds in wallet');
            }

            auth()->user()->wallet_balance = auth()->user()->wallet_balance - Setting::first()->value('advert_price');
            auth()->user()->save();

            $this->createAdvertSlot(Setting::first()->value('advert_price'));
        }
        if($request->has('payment_method') && $request->payment_method == 'referral'){
            if(auth()->user()->referral_wallet_balance < Setting::first()->value('advert_price')){
                return back()->with('error', 'Not enough funds in referral wallet');
            }
            auth()->user()->referral_wallet_balance = auth()->user()->referral_wallet_balance - Setting::first()->value('advert_price');
            auth()->user()->save();
            
            $this->createAdvertSlot(Setting::first()->value('advert_price'));
        }

        if($request->has('payment_method') && $request->payment_method == 'medal'){
            auth()->user()->medals_wallet_balance = auth()->user()->medals_wallet_balance - Setting::first()->value('advert_price');
            auth()->user()->save();
            
            $this->createAdvertSlot(Setting::first()->value('advert_price'));
        }

        if($request->has('payment_method') && $request->payment_method == 'coinbase'){
            //delete all user transactions that have not been confirmed over the last 1 day
            $transactionsToDelete = auth()->user()->transactions()->where('status', 'PENDING')->where('created_at', '<', Carbon::now()->subDay(7))->get();
            Transaction::destroy($transactionsToDelete->pluck('id'));

            $setting = Setting::first();
            $amount = $setting->value('advert_price');
 
            $charge = $this->createCharge('Advert Payment', $amount, auth()->user()->id, $request->type, auth()->user()->plans->id, 1, null);
            
            $transaction = $this->createTransactionLog(auth()->user()->id, $charge['data']['id'], $amount, 'PENDING', $request->type, json_encode($charge['data']), null);

            return redirect()->away($charge['data']['hosted_url']);
        }
        
        return redirect(route('advert.index'))->with('message', 'Operation Successful, You can choose the open slot in the table below, click edit to add your advert link');
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function show(Advert $advert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function edit(Advert $advert)
    {
       
        if($advert->status != 0 && auth()->user()->user_types == 1){
            return back()->with('error', 'You cannot edit this advert because it is been processed!');
        }
        return view('backend.user.updateAdvert', compact('advert'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advert $advert)
    {
        if($advert->status != 0 && auth()->user()->user_types == 1){
            return back()->with('error', 'You cannot edit this advert because it is been processed!');
        }
        
        $data = $this->validate($request, [
            'link' => 'required|url',
            'comment' => 'nullable',
        ]);

        $advert->update($data);

        if(auth()->user()->user_types != 1 ){
            return redirect(route('advert.index'))->with('message', 'Operation Sucessful');
        }
        //Notify Admin
        $data = [
            'type' => 'advert_created',
            'recipient' => 'Admin',
            'advert_number' => $advert->advert_number,
            'name' => auth()->user()->name,
            'amount' => $advert->amount_paid,
            'link' => $advert->link,
            'comment' => $advert->comment,
        ];
        //Send mail to User
        $email = Setting::first()->value('advert_email');
        if(!is_null($email)){
            Mail::to($email)->send(new generalEmail($data));
        }
        
        return redirect(route('advert.index'))->with('message', 'Operation Sucessful');
    }

    public function approveAdvert($id){
        $advert = Advert::find($id);
        $advert->status = 1;
        $advert->save();

        Task::create([
            'title' => 'Sponsored Task from ' . $advert->user->username,
            'status' => 'Publish',
            'advert_id' => $advert->id,
            'posturl' => $advert->link,
        ]);

        $data = [
            'type' => 'advert_approved',
            'recipient' => $advert->user->name,
            'advert_number' => $advert->advert_number,
        ];
        //Send mail to User
        Mail::to($advert->user->email)->send(new generalEmail($data));
                                    
        return redirect(route('advert.index'))->with('message', 'Advert approved');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advert $advert)
    {
        //
    }
}
