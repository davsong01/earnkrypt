<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Setting;
use App\Mail\generalEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DesignController extends Controller
{
    public function __construct(){
        $this->middleware(['verified', 'auth', 'hasPlan'])->only(['create', 'edit', 'update', 'processPayment']);
        $this->middleware(['admin'])->only(['process']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_types != 1 ){
            $designs = Design::orderBy('created_at', 'desc')->get();
            return view('backend.admin.designs.index', compact('designs'));
        }

        if(auth()->user()->user_types == 1 ){
            
            $jsonresponse = json_decode($this->getCharges(), true);
            
            //Get all advert payments made by this user via coinbase
            $userPayments = Design::select('user_id', 'transaction_id')->whereUserId(auth()->user()->id)->whereNotNull('transaction_id')->wherePaymentType('Coinbase')->get()->toArray();
            
            $userPaymentsArray = array_merge_recursive(array_column($userPayments, 'transaction_id'));
            $designNamesArray = ['EarnKrypt: Graphics Video', 'EarnKrypt: Order for Logo', 'EarnKrypt: Order for Flier'];
           
            $settings = Setting::first();
            //Create an array of pyaments that are confirmed but are not yet created 
            $allPayments = collect($jsonresponse['data'])->whereNotIn('id',  $userPaymentsArray)->where('payments', '!=', null)->whereIn('name', $designNamesArray); 
                   
            foreach($allPayments as $payment){
                if(isset($payment['payments'][0]) && $payment['payments'][0]['status'] == 'CONFIRMED'){
                    // If amount is exact
                        $amount_paid = $payment['payments'][0]['value']['local']['amount'];
                        $payment_id = $payment['id'];
                        $price = 0;
                        $percentage_bonus = !is_null($settings->value('design_referral_percent')) ? ((double) $settings->value('design_referral_percent')/100) * $amount_paid : 0;

                    if($payment['name'] == 'EarnKrypt: Order for Logo'){
                        $price = (double) $settings->value('logo_price');
                        $type = 'Logo';
                    }

                    if($payment['name'] == 'EarnKrypt: Order for Flier'){
                        $price = (double) $settings->value('flier_price');
                        $type = 'Flier';
                    }

                    if($payment['name'] == 'EarnKrypt: Graphics Video'){
                        $price = (double) $settings->value('graphics_video_price');
                        $type = 'Graphics Video';
                    }
                    
                    $this->processDesignPayments($payment['name'], $price, $amount_paid, $type, $payment['id'], $percentage_bonus, $payment);
                   
                }
            }
                        
            $designs = Design::whereUserId(auth()->user()->id)->latest()->get();

            return view('backend.user.designs', compact('designs'));
        }

    }

    public function processDesignPayments($purpose, $price, $amount_paid, $type, $payment_id, $percentage_bonus, $payment){
  
        if(!is_null($price) && ($amount_paid == $price)){
            
            $this->createSlot($type, $amount_paid, $payment_id, 'Coinbase', $payment);
            $this->updateUplineOnAdvertDesignPayment($percentage_bonus);
            $this->sendAdvertDesignEmail('advert_payment_received', $amount_paid, $purpose);
        }

        // If amount paid is over
        if(!is_null($price) && ($amount_paid > $price)){
            $balance = $amount_paid - $price;
            auth()->user()->update([
                'wallet_balance' => $balance,
            ]);

            // $this->createSlot($payment_id, 'Coinbase');
            $this->createSlot($type, $amount_paid, $payment_id, 'Coinbase', $payment);
            $this->updateUplineOnAdvertDesignPayment($amount_paid, $percentage_bonus);
            $this->sendAdvertDesignEmail('over_payment_received_for_advert', $amount_paid, $purpose, $balance);
        }
        
        // If underpayment
        if(!is_null($price) && ($amount_paid > $price)){
            $balance = $price - $amount_paid;
            $this->sendAdvertDesignEmail('under_payment_received_for_advert', $amount_paid, $purpose, $balance, $price);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.createdesign');
    }

    public function processPayment(Request $request){
        $type = $request->type;
        $amount = Setting::first()->value($type.'_price');
        
        if($request->payment_method == 'wallet'){
            
            $balance = $this->checkLogoPaymentFromBalance(auth()->user()->wallet_balance, $amount);//wallet balance, design cost
            if($balance == 0){
                return back()->with('error', 'Not enough funds in wallet');
            }

            auth()->user()->wallet_balance = auth()->user()->wallet_balance - $amount;
            auth()->user()->save();
           
            $this->createSlot($type, $amount);
        }


        if($request->payment_method == 'referral'){
             $balance = $this->checkLogoPaymentFromBalance(auth()->user()->referral_wallet_balance, $amount);//wallet balance, design cost
            if($balance == 0){
                return back()->with('error', 'Not enough funds in wallet');
            }

            auth()->user()->referral_wallet_balance = auth()->user()->referral_wallet_balance - $amount;
            auth()->user()->save();
           
            $this->createSlot($type, $amount);
        }

        if($request->payment_method == 'medal'){
            $balance = $this->checkLogoPaymentFromBalance(auth()->user()->medals_wallet_balance, $amount);//wallet balance, design cost
           if($balance == 0){
               return back()->with('error', 'Not enough funds in wallet');
           }

           auth()->user()->medals_wallet_balance = auth()->user()->medals_wallet_balance - $amount;
           auth()->user()->save();
          
           $this->createSlot($type, $amount);

       }

        if($request->payment_method == 'coinbase'){
            //Create Coinbase payment
            $amount = Setting::first()->value($type.'_price');
            $back_route = 'design.index';

            $link = $this->getPaymentLink($request->type);
            return view('backend.user.checkOut', compact('amount', 'link', 'back_route'));
            $amount_to_pay = $this->getPayment($request->type);      
        }

        return redirect(route('design.index'))->with('message', 'Operation Successful, You can choose the open slot in the table below, click edit to tell us more about your design');
       
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
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design)
    {
        if($design->status != 0 && auth()->user()->user_types == 1){
            return back()->with('error', 'You cannot edit this design because it is been processed!');
        }
        return view('backend.user.updateDesign', compact('design'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Design $design)
    {
        if($design->status != 0){
            return back()->with('error', 'You cannot edit this design because it is been processed!');
        }
        
        $data = $this->validate($request, [
            'description' => 'nullable',
        ]);

        $design->update($data);

        if(auth()->user()->user_types != 1 ){
            return redirect(route('design.index'))->with('message', 'Operation Sucessful');
        }
        //Notify Admin
        $data = [
            'type' => 'design_created',
            'recipient' => 'Admin',
            'design_number' => $design->design_number,
            'name' => auth()->user()->name,
            'amount' => $design->amount_paid,
            'description' => $design->description,
        ];
        //Send mail to User
        $email = Setting::first()->value('design_email');
        if(!is_null($email)){
            Mail::to($email)->send(new generalEmail($data));
        }

        return redirect(route('design.index'))->with('message', 'Design order successfully placed');
    }

    public function approveDesign(Request $request){
        $design = Design::find($request->id);
        $design->status = $request->status;

        if($request->status == 1){
            $status = 'Processing';
            
            $this->sendProcessingMail($design, $status);
        } 
        
        if($request->status == 2){
            $status = 'Complete';
            if($design->type == 'logo' || $design->type == 'flier'){
                $file = $this->validate($request, [
                    'file' => 'required',
                ]);
                
                $filename = date('D-s-i');
                $extension = $request->file('file')->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('designs', $filename . '.' . $extension,'uploads');

                $attachment = base_path() . '/uploads'.'/'. $filePath;

                $this->sendCompleteMail($status, $design, $attachment, $request->url);
                $design->file = $filename . '.' . $extension;
            }

            if($design->type == 'graphics_video'){
                $file = $this->validate($request, [
                    'url' => 'required|url',
                ]);

                $this->sendCompleteMail($status, $design, $request->file, $request->url);
                $design->file = $request->url;
            }
        
        }
        $design->save();

        return redirect(route('design.index'))->with('message', 'Design Status changed succesfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design)
    {
        //
    }
}
