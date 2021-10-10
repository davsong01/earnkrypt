<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Advert;
use App\Models\Design;
use App\Models\Setting;
use App\Mail\generalEmail;
use App\Models\Transaction;
use App\Mail\paymentComplete;
use App\Models\publishing_plans;
use Illuminate\Support\Facades\Mail;
use Shakurov\Coinbase\Facades\Coinbase;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirect($request){
            // $plan = publishing_plans::whereId($request->plan_id)->first();

            //delete all user transactions that have not been confirmed over the last 1 day
            $transactionsToDelete = auth()->user()->transactions()->where('status', 'PENDING')->where('created_at', '<', Carbon::now()->subDay(7))->get();
            Transaction::destroy($transactionsToDelete->pluck('id'));
            
            $transaction = auth()->user()->transactions()->where('status', 'PENDING')->where('type', $request->type)->first();
            //if type == 1, i.e. Plan... we dont want multiple payments for a single plan
            if($request->type && $request->type == 1){
                $plan = publishing_plans::whereId($request->plan_id)->first();
                $charge = $this->createCharge($plan->title, $plan->amount, auth()->user()->id, $request->type, $request->plan_id, 1);

                if(is_null($transaction)){
                    // Create new/
                    $transaction = $this->createTransactionLog(auth()->user()->id, $charge['data']['id'], $plan->amount, 'PENDING', $request->type, json_encode($charge['data']));

                }else{
                    $transaction->reference = $charge['data']['id'];
                    $transaction->save();
                }
            }
            

            return redirect()->away($charge['data']['hosted_url']);
          
    }

    protected function createSlot($amount, $payment_id = null, $payment_type = null, $payment = null ){
        
        $design = Design::create([
            'user_id' => auth()->user()->id,
            'amount_paid' => $amount,
            'transaction_id' => $payment_id,
            'variation' => $payment_type,
        ]);
    
        if(!empty($payment)){
            $transaction = Transaction::whereReference($payment_id)->first();
            
            $transaction->update([
                'status' => 'CONFIRMED',
                'payment_data' => json_encode($payment),
            ]);  
        }
  
        $design->update(['design_number' => 'EKRYPT-' . substr($payment_type, 0, 1) . substr($payment_type, -1) . '-' . date('Y') . '-' . $design->id]);
    }

    protected function checkLogoPaymentFromBalance($balance, $amount){
        if($balance < $amount){
            return 0;
        }else{
            return 1;
        }
    }


    protected function createAdvertSlot($amount, $trans_id = null, $payment_type = null, $payment = null){
        $advert = Advert::create([
            'user_id' => auth()->user()->id,
            'amount_paid' => $amount,
            'transaction_id' => $trans_id ?? null,
            'payment_type' => $payment_type ?? null,
        ]);

        if(!empty($payment)){
            $transaction = Transaction::whereReference($trans_id)->first();
            
            $transaction->update([
                'status' => 'CONFIRMED',
                'payment_data' => json_encode($payment),
            ]); 
        }

        $advert->update(['advert_number' => 'EKRYPT-' . date('Y') . '-' . $advert->id]);
        
        return;
    }

    protected function sendProcessingMail($design, $status){

        $data = [
            'type' => 'design_status',
            'recipient' => $design->user->name,
            'design_number' => $design->design_number,
            'status' => $status,
        ];

        Mail::to($design->user->email)->send(new generalEmail($data));                            
    }

    protected function sendCompleteMail($status, $design, $file = null, $url = null){
        $data = [
            'type' => 'design_complete',
            'recipient' => $design->user->name,
            'design_number' => $design->design_number,
            'status' => $status,
        ];

        if(!is_null($file)){
            $data['file'] = $file;
        }

        if(!is_null($url)){
            $data['url'] = $url;
        }

        Mail::to($design->user->email)->send(new generalEmail($data));                            
    }

    protected function sendAdvertDesignEmail($payment_id, $type, $amount, $purpose, $balance = null, $expected = null){
        $data = [
            'type' => $type,
            'name' => auth()->user()->name,
            'amount' => $amount,
            'purpose' => $purpose,
            'balance' => $balance,
            'expected' => $expected,
            'payment_id' => $payment_id,
        ];

        if(!is_null(auth()->user()->email)){
            Mail::to(auth()->user()->email)->send(new generalEmail($data));
        }
    }

    protected function updateUplineOnAdvertDesignPayment($percentage_bonus){
        //Update referral bonus
        if(auth()->user()->upline()->first() != NULL){
            auth()->user()->upline()->first()->update([
                'referral_wallet_balance' => auth()->user()->upline()->first()->referral_wallet_balance +  $percentage_bonus,
            ]);
        }
    }
    
    protected function updateReferral($plan){
        if(auth()->user()->plan_expiry){
            $difference = Carbon::now()->diffInDays(auth()->user()->plan_expiry, false);
            if($difference > 0){
                $plan_expiry = Carbon::now()->addDays($plan->validity + $difference) ;
            }else{
                $plan_expiry  = Carbon::now()->addDays($plan->validity);
                
            }
        }else{
            $plan_expiry = Carbon::now()->addDays($plan->validity);
        }
       
        //Update referral bonus
        $percent_bonus = (Setting::select('referral_percent')->first()->value('referral_percent')/100) * $plan->amount;
        if(auth()->user()->upline()->first() != NULL){
            auth()->user()->upline()->first()->update([
                'referral_wallet_balance' => auth()->user()->upline()->first()->referral_wallet_balance +  $percent_bonus,
            ]);
        }
        return auth()->user()->upline()->first();
    }

    protected function createTransactionLog($user_id, $ref, $amount, $status, $type, $data, $variation = null){
        
        $transaction = Transaction::updateOrCreate([
            'reference' => $ref,
            'user_id' => $user_id,
            'amount' => $amount,
            'status' => $status,
            'type' => $type,
            'payment_data' => $data,
            'variation' => $variation ?? null
        ]);

        return;
    }

    protected function createCharge($name, $amount, $user_id, $type, $plan_id = null, $quantity, $variation = null){
        // dd($name, $amount, $user_id, $quantity);
        $charge = Coinbase::createCharge([
            'name' => $name,
            'description' => $name,
            'local_price' => [
                'amount' => $amount,
                'currency' => 'USD',
            ],
            'metadata' => [
                'user_id' => $user_id,
                'type' => $type , //1 - plans, 2 - adverts, 3 - designs
                'plan_id' => $plan_id ?? auth()->user()->plans->id,
                'quantity' => $quantity,
                'variation' => $variation ?? null, //Used by designs
            ],
    
            'pricing_type' => 'fixed_price',
        ]);
        return $charge;
    }
   
    // protected function getCharges($url){
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.commerce.coinbase.com/charges',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 100,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //         CURLOPT_HTTPHEADER => array(
    //             'X-CC-Api-Key: 289d349d-831d-4d2a-99fa-012db1dadb03',
    //             'Cookie: __cfduid=db701e704100840bad156cdfdc957b7ae1616524238; amplitude_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f; coinbase_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f'
    //         ),
           
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);

    //     return $response;
    // }

    protected function getTransactionDetails($id){
        return Coinbase::getCharge($id);
    }

    protected function processTransaction($plan, $payment, $type){ //1 - plans, 2 - adverts, 3 - designs
        if($type == 1){
            // add plan value
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
            $this->updateReferral($plan); 
           
            Mail::to(auth()->user()->email)->send(new paymentComplete(auth()->user(), $payment['name'], $payment['payments'][0]['value']['local']['amount']));
    
            Mail::to(Setting::select('official_mail')->first()->value('official_mail'))->send(new paymentComplete(auth()->user(), $payment['name'], $payment['payments'][0]['value']['local']['amount']));
        }

        if($type == 2){
            // add advert value
        }

        if($type == 3){
            // add design value
        }

        // create transaction log
        $this->UpdateTransactionLog($payment['id'], $payment['payments'][0]['status'], json_encode($payment)); 
                    
    }

    protected function updateTransactionLog($ref, $status, $data){
        $transaction = Transaction::where('reference', $ref)->first();
    
        $transaction->update([
            'reference' => $ref,
            'status' => $status,
            'payment_data' => $data,
        ]);

        return;
    }
    // protected function getCharges(){
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.commerce.coinbase.com/charges',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 100,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //         CURLOPT_HTTPHEADER => array(
    //             'X-CC-Api-Key: 289d349d-831d-4d2a-99fa-012db1dadb03',
    //             'Cookie: __cfduid=db701e704100840bad156cdfdc957b7ae1616524238; amplitude_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f; coinbase_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f'
    //         ),
           
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
       
    //     $data = json_decode($response, true);
    //     $push = $data['data'];
    //     dd($push);
    //     while(!is_null($data['pagination']['nex_uri'])){

    //     }
    //     return $response;
    // }

}
