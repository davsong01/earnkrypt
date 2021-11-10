<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Setting;
use App\Mail\generalEmail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        set_time_limit(240);
        
        if(auth()->user()->user_types != 1 ){
            $designs = Design::orderBy('created_at', 'desc')->get();
            return view('backend.admin.designs.index', compact('designs'));
        }

        if(auth()->user()->user_types == 1 ){
            $allPayments = collect(auth()->user()->transactions->where('type', 4)->where('status', 'PENDING'));
           
            if($allPayments){
                
                 //loop through all payments and deliver value
                foreach($allPayments as $payment){
                    // print_r($payment);
                   
                        $transactionDetails = collect($this->getTransactionDetails($payment->reference));
                    
                        if(isset($transactionDetails['payments'][0]) && $transactionDetails['payments'][0]['status'] == 'CONFIRMED'){
                            $name = $transactionDetails['metadata']['variation'] ?? $payment->variation .  ' design';
                            $variation = $transactionDetails['metadata']['variation'] ?? $payment->variation;
                            
                            $percentage_bonus = !is_null(Setting::first()->value('design_referral_percent')) ? ((double) Setting::first()->value('design_referral_percent')/100) * $transactionDetails['payments'][0]['value']['local']['amount'] : 0;
                           
                            $this->processDesignPayments($name, $payment->amount, $transactionDetails['payments'][0]['value']['local']['amount'], $variation, $payment->reference, $percentage_bonus, $transactionDetails);
                                                       
                        }
                    
                }
                   
            }
               
            $designs = Design::whereUserId(auth()->user()->id)->latest()->get();

            return view('backend.user.designs', compact('designs'));
        }

    }

    public function processDesignPayments($purpose, $price, $amount_paid, $type, $payment_id, $percentage_bonus, $payment){
 
        if(!is_null($price) && ($amount_paid == $price)){
            $this->createSlot($amount_paid, $payment_id, $type, $payment);
            $this->updateUplineOnAdvertDesignPayment($percentage_bonus);
            $this->sendAdvertDesignEmail($payment_id, 'advert_payment_received', $amount_paid, $purpose);
        }

        // If amount paid is over
        if(!is_null($price) && ($amount_paid > $price)){
            $balance = $amount_paid - $price;
            auth()->user()->update([
                'wallet_balance' => $balance,
            ]);
           
            $this->createSlot($amount_paid, $payment_id, 'Coinbase', $payment, $purpose);
            $this->updateUplineOnAdvertDesignPayment($amount_paid, $percentage_bonus);
            $this->sendAdvertDesignEmail($payment_id, 'over_payment_received_for_advert', $amount_paid, $purpose, $balance);
        }
        
        // If underpayment
        if(!is_null($price) && ($amount_paid < $price)){
            $balance = $price - $amount_paid;
            $this->sendAdvertDesignEmail($payment_id, 'under_payment_received_for_advert', $amount_paid, $purpose, $balance, $price);
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
        // dd($request->all());
        $type = $request->variation;
        $amount = Setting::first()->value($type.'_price');
        
        if($request->payment_method == 'wallet'){
            
            $balance = $this->checkLogoPaymentFromBalance(auth()->user()->wallet_balance, $amount);//wallet balance, design cost
            if($balance == 0){
                return back()->with('error', 'Not enough funds in wallet');
            }

            auth()->user()->wallet_balance = auth()->user()->wallet_balance - $amount;
            auth()->user()->save();
           
            $this->createSlot($amount, null, $type);

            return redirect(route('design.index'))->with('message', 'Operation Successful, You can choose the open slot in the table below, click edit to tell us more about your design');
        }


        if($request->payment_method == 'referral'){
             $balance = $this->checkLogoPaymentFromBalance(auth()->user()->referral_wallet_balance, $amount);//wallet balance, design cost
            if($balance == 0){
                return back()->with('error', 'Not enough funds in wallet');
            }

            auth()->user()->referral_wallet_balance = auth()->user()->referral_wallet_balance - $amount;
            auth()->user()->save();
           
            $this->createSlot($amount, null, $type);
           
            return redirect(route('design.index'))->with('message', 'Operation Successful, You can choose the open slot in the table below, click edit to tell us more about your design');

        }

        if($request->payment_method == 'medal'){
            $balance = $this->checkLogoPaymentFromBalance(auth()->user()->medals_wallet_balance, $amount);//wallet balance, design cost
           if($balance == 0){
               return back()->with('error', 'Not enough funds in wallet');
           }

           auth()->user()->medals_wallet_balance = auth()->user()->medals_wallet_balance - $amount;
           auth()->user()->save();
          
           $this->createSlot($amount, null, $type);

           return redirect(route('design.index'))->with('message', 'Operation Successful, You can choose the open slot in the table below, click edit to tell us more about your design');

       }

        if($request->payment_method == 'coinbase'){
             //delete all user transactions that have not been confirmed over the last 1 day
             $transactionsToDelete = auth()->user()->transactions()->where('status', 'PENDING')->where('created_at', '<', Carbon::now()->subDay(7))->get();
             Transaction::destroy($transactionsToDelete->pluck('id'));

            $amount = Setting::first()->value($request->variation.'_price');

            $charge = $this->createCharge($request->variation, $amount, auth()->user()->id, $request->type, null, 1, $request->variation);
            
            $transaction = $this->createTransactionLog(auth()->user()->id, $charge['data']['id'], $amount, 'PENDING', $request->type, json_encode($charge['data']), $request->variation);

            return redirect()->away($charge['data']['hosted_url']);
                      
        }

      
       
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
