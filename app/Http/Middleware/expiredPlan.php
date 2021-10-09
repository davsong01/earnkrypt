<?php

namespace App\Http\Middleware;

use auth;
use Closure;
use Carbon\Carbon;
use App\Models\Setting;
use App\Mail\paymentComplete;
use App\Models\publishing_plans;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class expiredPlan
{

    public function handle($request, Closure $next)
    {
        // if (Auth::check()){

        //     if(Carbon::parse(auth()->user()->plan_expiry) < Carbon::now() && auth()->user()->user_types == 1){

        //         $plans = publishing_plans::all();
           
        //         $curl = curl_init();
        
        //         curl_setopt_array($curl, array(
        //         CURLOPT_URL => 'https://api.commerce.coinbase.com/charges',
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => '',
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => 'GET',
        //         CURLOPT_HTTPHEADER => array(
        //             'X-CC-Api-Key: 289d349d-831d-4d2a-99fa-012db1dadb03',
        //             'Cookie: __cfduid=db701e704100840bad156cdfdc957b7ae1616524238; amplitude_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f; coinbase_device_id=f1103d1d-59eb-4137-b39a-336c6ca6005f'
        //           ),
        //         ));
        
        //         $response = curl_exec($curl);
        
        //         curl_close($curl);
        //         $jsonresponse = json_decode($response, true);

        //         //Get all payments which happened after the expiry of this user plan
        //         $allPayments = collect($jsonresponse['data'])->where('payments', '!=', null)->where('confirmed_at', '>', auth()->user()->plan_expiry);
        //         // dd($allPayments);
        //         //filter all payments to get this user payments
        //         $allPayments = $allPayments->filter(function($allPayments){
        //             if(strtolower($allPayments['metadata']['email']) == strtolower(auth()->user()->email) && $allPayments['name'] == auth()->user()->plans->title && $allPayments['payments'][0]['status'] == 'CONFIRMED' && $allPayments['payments'][0]['value']['local']['amount'] == auth()->user()->plans->amount){
        //                 return $allPayments;
        //             }
        //         });
             
        //         if($allPayments->count() > 0){
        //             $allPayments = $allPayments->first();
        //             // dd($allPayments);
        //             //Add value to customer
        //             auth()->user()->plan_expiry = Carbon::parse($allPayments['confirmed_at'])->addMonth(1);
        //             // in case of overpayment

        //             if( $allPayments['payments'][0]['value']['local']['amount'] >  auth()->user()->plans->amount){
        //                 auth()->user()->wallet_balance = auth()->user()->wallet_balance + ($allPayments['payments'][0]['value']['local']['amount'] -  auth()->user()->plans->amount);
        //             }
        //             auth()->user()->save();

        //             //Update upline referral bonus here
        //             $percent_bonus = (Setting::select('referral_percent')->first()->value('referral_percent')/100) * auth()->user()->plans->amount;
        //             if(auth()->user()->upline()->first() != NULL){
        //                 auth()->user()->upline()->first()->update([
        //                     'referral_wallet_balance' => auth()->user()->upline()->first()->referral_wallet_balance +  $percent_bonus,
        //                 ]);
        //             }

        //             Mail::to(auth()->user()->email)->send(new paymentComplete(auth()->user(), auth()->user()->plans->title, $allPayments['payments'][0]['value']['local']['amount']));
        //             Mail::to(Setting::select('official_mail')->first()->value('official_mail'))->send(new paymentComplete(auth()->user(), auth()->user()->plans->title, $allPayments['payments'][0]['value']['local']['amount']));

        //             return $next($request);
        //         }
        //     }
              
        //     if (Carbon::parse(auth()->user()->plan_expiry) < Carbon::now() && auth()->user()->user_types == 1 ) {
        //         auth()->user()->medals()->detach();
        //         $title = 'Renew or purchase plan';
        //         return redirect(url('/renewplan'));
        //     }
        // }

        return $next($request);
    }
}
