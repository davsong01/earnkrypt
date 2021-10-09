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
use Illuminate\Support\Facades\Session;
use Shakurov\Coinbase\Facades\Coinbase;

class hasPlan extends Controller
{

    public function handle($request, Closure $next)
    {
 
        if (Auth::check()){
           
            //check if user has no plan
            if (is_null(auth()->user()->plans) && auth()->user()->user_types == 1 ) {
                $userTransaction = auth()->user()->transactions->where('type', 1)->where('status', 'PENDING')->first();
                 //user has no plan and has not made any attempt to pay
                if(is_null($userTransaction)){
                    return redirect(url('/selectplans'));
                }else{
                    //Check transaction status
                    $transactionDetails = collect($this->getTransactionDetails($userTransaction->reference)['data']);

                    //No payment
                    if(empty($transactionDetails['payments'])){
                        return redirect(url('/selectplans'));
                    }
                    //There is payment but it is not confirmed
                    if(!empty($transactionDetails['payments'])){
                        $id = $transactionDetails['id'];
                        return redirect(route('confirm.payment', $id));
                    }
                }

            }

            if (Carbon::parse(auth()->user()->plan_expiry) < Carbon::now() && auth()->user()->user_types == 1 ) {
           
                auth()->user()->medals()->detach();
                    $userTransaction = auth()->user()->transactions->where('type', 1)->where('status', 'PENDING')->first();
                    //user has no plan and has not made any attempt to pay
                    if(is_null($userTransaction)){
                        return redirect(url('/renewplan'));
                    }else{
                        //Check transaction status
                        $transactionDetails = collect($this->getTransactionDetails($userTransaction->reference)['data']);

                        //No payment
                        if(empty($transactionDetails['payments'])){
                            return redirect(url('/renewplan'));
                        }
                        //There is payment but it is not confirmed
                        if(!empty($transactionDetails['payments'])){
                            $id = $transactionDetails['id'];
                            return redirect(route('confirm.payment', $id));
                        }
                    }
            }
        }
        
        return $next($request);
    }

}

