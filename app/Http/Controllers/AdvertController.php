<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Advert;
use App\Models\Setting;
use App\Mail\generalEmail;
use Illuminate\Http\Request;
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
                
            $jsonresponse = json_decode($this->getCharges(), true);
            //Get all advert payments made by this user via coinbase
            $userPayments = Advert::select('user_id', 'transaction_id')->whereUserId(auth()->user()->id)->whereNotNull('transaction_id')->wherePaymentType('Coinbase')->get()->toArray();
           
            $userPaymentsArray = array_merge_recursive(array_column($userPayments, 'transaction_id'));
            
            $advertNamesArray = ['EarnKrypt Advert Placement'];

            //Create an array of pyaments that are confirmed but are not yet created 
            $allPayments = collect($jsonresponse['data'])->whereNotIn('id',  $userPaymentsArray)->whereIn('name', $advertNamesArray)->where('payments', '!=', null); 

            $settings = Setting::first();

            foreach($allPayments as $payment){
                if(isset($payment['metadata']) && strtolower($payment['metadata']['email']) == strtolower(auth()->user()->email) && isset($payment['payments'][0]) && $payment['payments'][0]['status'] == 'CONFIRMED' ){
                    // If amount is exact
                    $payment_id = $payment['id'];
                    $amount_paid = $payment['payments'][0]['value']['local']['amount'];
                    $percent_bonus = ($settings->advert_referral_percent/100) * $amount_paid;
                    if(!is_null($settings->advert_price) && ( $amount_paid == $settings->advert_price)){
                    
                        $this->createAdvertSlot($amount_paid, $payment_id, 'Coinbase', $payment);
                        $this->updateUplineOnAdvertDesignPayment($percent_bonus);
                        $this->sendAdvertDesignEmail('advert_payment_received', $amount_paid, 'Advert');
                    }

                    // If amount paid is over
                    if(!is_null($settings->advert_price) && ($amount_paid > $settings->advert_price)){
                       
                        $balance = $amount_paid - $settings->advert_price;
                        auth()->user()->update([
                            'wallet_balance' => $balance,
                        ]);

                        $this->createAdvertSlot($payment_id, $amount_paid, 'Coinbase', $payment);
                        $this->updateUplineOnAdvertDesignPayment($amount_paid, $percent_bonus);
                        $this->sendAdvertDesignEmail('over_payment_received_for_advert', $amount_paid, 'Advert', $balance);
                        
                    }

                    // If underpayment
                    if(!is_null($settings->advert_price) && ($amount_paid > $settings->advert_price)){
                        $balance = $settings->advert_price - $amount_paid;

                        $this->sendAdvertDesignEmail('under_payment_received_for_advert', $amount_paid, 'Advert', $balance, $settings->advert_price);

                    }
                }
            }
                      
            $adverts = Advert::whereUserId(auth()->user()->id)->latest()->get();
        }
 
        return view('backend.user.adverts', compact('adverts'));
    
    
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

            $setting = Setting::first();
            $link = $setting->value('advert_payment_link');
            $amount = $setting->value('advert_price');
            $back_route = 'advert.index';

            return view('backend.user.checkOut', compact('amount', 'link', 'back_route'));
  
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
