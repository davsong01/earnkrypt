@extends('backend.layouts.admin')
@section('title', 'Renew Plan')
@section('content')
<div class="container-fluid; margin: auto;">
    <div class="card">
        <div class="card-header">
            <div class="section-header wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
        
            <!-- SECTION TITLE -->
            <h2 class="dark-text">Renew Membership Plan</h2>
            <div class="colored-line">
            </div>
                <div class="section-description">
                    Dear {{ auth()->user()->name }}, you are currently on the <strong>{{ auth()->user()->plans->title }}</strong> membership plan. <br> 
                    Unfortunately, your subscription for this plan has expired. <br>
                   <strong>Good news!</strong> You can renew your membership plan here or you can <a class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit" href="/userselectnewplan"> Select a different membership plan</a>
            </div>
            <h4 class="dark-text">Do not have a crypto account?</h4>
            <div class="colored-line">
            </div>
                <div class="section-description">
                Not to worry, Click the renew button below, enter your email and come back and click <a href="{{ route('vendor.viewall') }}" target="_blank"><strong>HERE</strong></a> to ask one of our verified and trusted vendors to make payment for you. <br>
                <strong>NOTE: </strong> Do not send payment details to vendor except you have concluded negotiations with vendor
            </div>
            
        </div>
    </div>
    
	</div>
	
    <div class="row" style="padding: 20px;">
		
		<!-- SINGLE PACKACGE -->
        @if (isset($paymentmessage))
            <div class="card">
                <div class="card-header">
                    <h3>Payment Update</h3>
                </div>
                <div class="card-body">
                    <h3>{{$paymentmessage}}</h3>
                    <hr>
                    @if (isset($paymentstatus))
                    <h3>Payment Status: {{$paymentstatus}}</h3>
                    @endif
                </div>
            </div>
        @else
		<div class="col-md-12 col-sm-12 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
			<div class="single-package" style="width: 100%; margin: auto; max-width: 506px;">
				{{-- <form action="{{ route('plan.store') }}" method="POST"> --}}
                    {{-- @csrf --}}
				    <h3 style="text-align: center;" class="package-heading main-color" style="text-align: center;">
                        {{ $plan->title }}
                    </h3>
				
                    <div class="price">
                        <div class="color-bg">   
                            <h2><span class="sign">${{ $plan->amount }} USD</span></h2>
                        </div>
                    </div>
                    
                    <ul class="package-feature">
                        {!! $plan->description !!}
                        
                    </ul>
                    <input type="hidden" name="plan" value="{{ $plan->id }}" required>
                    <div>
                        <div>
                            <a style="width: 100%;" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                               target="_blank" href="{{ $plan->payment_link }}">
                              Renew Now
                            </a>
                            <script src="https://commerce.coinbase.com/v1/checkout.js?version=201807?onload=myfunction()" >
                            </script>
                            <script>
                                myfunction(){
                                    alert('hello');
                                }
                            </script>
                          </div>
                      
                        </a>
                    </div>

                    
			</div>
		</div>
        @endif

        
	</div>
    <div class="card-body">
        <div class="row" id="faq">
            <h4>Payment Tips & FAQs</h4>
            <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    What is an underpayment and how can I avoid making one?
                </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse closed" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    An underpayment is when you send a lower amount than required/expected for your payment. Although they are rare, they still happen, and always lead to the underpaid transaction not being processed. The most common cause of underpayments is converting the amount on the payment page to your local currency (usually with an exchange rate you found online), then sending that amount of your local currency in crypto. To ensure that your payment is successful and avoid an underpayment, be sure to send the exact amount of crypto displayed on the payment page. 
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    What is the exchange rate for my payment?
                </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    We do not set the exchange rate for your payment. This is set by the crypto wallet app you use. In fact, if you find yourself doing any conversions from USD to your local currency while trying to pay, you're doing it wrong, and your transaction will be underpaid. Don't type in the USD amount on your wallet app; type in the exact crypto amount displayed on the payment page using your wallet app instead. 
                </div>
                </div>
            </div>
        
        </div>
    </div>
   
</div>
@endsection
