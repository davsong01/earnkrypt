<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class generalEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        
        if(isset($this->data['type']) && $this->data['type'] == 'advert_approved'){
            return $this
                ->subject("Earnkrypt: Advert Approved")
                ->from('no-reply@Earnkrypt.com')
                ->markdown('emails.generalEmail', $this->data);
        }
        
        if(isset($this->data['type']) && $this->data['type'] == 'advert_created'){
            return $this
                ->subject("Earnkrypt: New Advert Created")
                ->from('no-reply@Earnkrypt.com')
                ->markdown('emails.generalEmail', $this->data);
        }
        
        if(isset($this->data['type']) && $this->data['type'] == 'design_created'){
            return $this
                ->subject("Earnkrypt: New Design Created")
                ->from('no-reply@Earnkrypt.com')
                ->markdown('emails.generalEmail', $this->data);
        }
        
        if(isset($this->data['type']) && $this->data['type'] == 'design_status'){
            return $this
                ->subject("Earnkrypt: Design Status Change")
                ->from('no-reply@Earnkrypt.com')
                ->markdown('emails.generalEmail', $this->data);
        }

        if(isset($this->data['type']) && $this->data['type'] == 'design_complete'){
            if(isset($this->data['url']) && !is_null($this->data['url'])){
                return $this
                    ->subject("Earnkrypt: Design Status Change")
                    ->from('no-reply@Earnkrypt.com')
                    ->markdown('emails.generalEmail', $this->data);
            }
        }
        if(isset($this->data['file']) && !is_null($this->data['file'])){
            return $this
                ->subject("Earnkrypt: Design Status Change")
                ->from('no-reply@Earnkrypt.com')
                ->attach($this->data['file'])
                ->markdown('emails.generalEmail', $this->data);
        }
        
        if(isset($this->data['type']) && $this->data['type'] == 'advert_payment_received'){
            
            return $this
                ->subject("Earnkrypt: Payment Received")
                ->from('no-reply@Earnkrypt.com')
                ->markdown('emails.generalEmail', $this->data);
        }

        if(isset($this->data['type']) && $this->data['type'] == 'over_payment_received_for_advert'){
           
            return $this
                ->subject("Earnkrypt: Payment Received")
                ->from('no-reply@Earnkrypt.com')
                ->markdown('emails.generalEmail', $this->data);
        }

        if(isset($this->data['type']) && $this->data['type'] == 'under_payment_received_for_advert'){
           
            return $this
                ->subject("Earnkrypt: Payment Received")
                ->from('no-reply@Earnkrypt.com')
                ->markdown('emails.generalEmail', $this->data);
        }
        
    }
}
