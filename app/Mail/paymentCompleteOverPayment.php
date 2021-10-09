<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class paymentCompleteOverPayment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user, $plan_type, $plan_amount, $overpayment;
    public function __construct($user, $plan_type, $plan_amount, $overpayment)
    {
        $this->user = $user;
        $this->plan_type = $plan_type;
        $this->plan_amount = $plan_amount;
        $this->overpayment = $overpayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject("Earnkrypt: Investor Plan Payment Success")
        ->from('no-reply@Earnkrypt.com')
        ->markdown('emails.paymentCompleteOverPayment', ['user' => $this->user, 'plan_type' => $this->plan_type, 'plan_amount' => $this->plan_amount, 'overpayment' => $overpayment]);
    }
}
