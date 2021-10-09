<?php 
foreach ($jsonresponse->data as $data) {
    if (strtolower($data->metadata->email) == strtolower(auth()->user()->email)) {
        # echo 'you tried to pay<br>';
        # check for payments
        if (empty($data->payments)) {
            $title = 'Purchase plan';
    
            return redirect(url('/selectplans'));
        }else{
            # echo 'you paid<br>';
            foreach ($data->payments as $paymentdata) {
                # show status
                if ($paymentdata->status == 'PENDING') {
                    $plans = publishing_plans::all();
                    $paymentmessage = 'Your Payment for your publishing plan is pending. Continue to refresh this page to the current status of your payment. You would also be notified via email when your payment has been confirmed';
                    $paymentstatus = $paymentdata->status;
                    // echo 'transaction is '.$paymentdata->status;
                    return view('backend.user.selectplans', compact('plans','paymentmessage','paymentstatus'));
                }elseif($paymentdata->status == 'CONFIRMED'){
                    # code...
                    # echo 'transaction is '.$paymentdata->status;
                    # get the title of the payment
                    if (publishing_plans::where('title','=',$data->name)) {
                        # the publishing plan exists now check for the publishing plan amount and check with the amount paid
                        $pubplan = publishing_plans::where('title','=',$data->name)->first();
                        if ($pubplan->amount == $paymentdata->value->local->amount) {
                            # if the amount is the same update user publishing plan
                            $user = User::findOrFail(auth()->user()->id); 
                            $user->publishing_plans_id = $pubplan->id;
                            $user->save();
                            // echo 'transaction is perfect your publishing plan has been updated';

                            //Update upline referral bonus here
                            $this->updateReferral($pubplan); 

                            Mail::to($user->email)->send(new paymentComplete($user, $data->name, $paymentdata->value->local->amount));
                            Mail::to(Setting::select('official_mail')->first()->value('official_mail'))->send(new paymentComplete($user, $data->name, $paymentdata->value->local->amount));
                            
                            
                            return redirect()->route('dashboard');
                        }elseif ($pubplan->amount < $paymentdata->value->local->amount) {
                           
                            $overpaymentbalance = $paymentdata->value->local->amount - $pubplan->amount;
                            $user = User::findOrFail(auth()->user()->id);
                            # add the balance to the wallet and update the users publishing plan
                            $user->wallet_balance = $user->wallet_balance + $overpaymentbalance;
                            $user->publishing_plans_id = $pubplan->id;
                            $user->save();
                            
                            return redirect()->route('dashboard');

                            # echo 'transaction is overpaid but publishing plan is updated';
                            Mail::to($user->email)->send(new paymentComplete($user, $data->name, $paymentdata->value->local->amount, $overpaymentbalance));
                        }elseif ($pubplan->amount > $paymentdata->value->local->amount) {
                            
                            $paymentmessage = 'Your payment was recieved but you made an underpayment. Kindly contact the admin to get a new link to complete your balance';
                            return view('backend.user.selectplans', compact('plans','paymentmessage'));

                            // echo 'transaction is underpayment. contact admin';

                            return redirect()->route('dashboard');
                            
                        }
                    }
                }
            }
        }
    }
}

return view('backend.user.selectplans', compact('plans'));
?>