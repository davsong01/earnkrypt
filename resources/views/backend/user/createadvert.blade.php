@extends('backend.layouts.admin')
@section('title', 'Create Advert')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <div class="card-header">
                        <div>
                            <p>Hi {{ auth()->user()->username }}, you are eligible to place advert links, however you need to make payment of <strong>${{ \App\Models\Setting::first()->value('advert_price') }}</strong> as advert fee per advert. After Payment is confirmed you will be given an advert slot <strong><a href="{{ route('advert.index') }}">HERE</a></strong> which you can edit and add your advert link <br>
                                You can choose to make payment from your wallets or with coinbase.                            
                            </p>
                           <br>
                        </div>
                        <h4 class="dark-text">Do not have a crypto account?</h4>
                        <div class="colored-line">
                        </div>
                            <p>
                                Not to worry, Click the make payment button for your preffered, enter your email and come back and click <a href="{{ route('vendor.viewall') }}" target="_blank"><strong>HERE</strong></a> to ask one of our verified and trusted vendors to make payment for you. <br>
                            <strong>NOTE: </strong> Do not send payment details to vendor except you have concluded negotiations with vendor
                            </p>
                            
                    </div>
                    <form action="{{ route('advert.pay') }}" method="POST"
                        enctype="multipart/form-data" class="pb-2" target="_blank">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <fieldset class="form-group">
                                    <label for="payment_method">Select Wallet to withdraw from</label>
                                    <select class="form-control" name="payment_method" id="payment_method" required>
                                        <option value="">Select Option</option>
                                        @if(auth()->user()->wallet_balance >= \App\Models\Setting::first()->value('advert_price'))
                                        <option value="wallet">Main Wallet (${{ auth()->user()->wallet_balance }} )</option>
                                        @endif
                                        @if(auth()->user()->referral_wallet_balance >= \App\Models\Setting::first()->value('advert_price'))
                                        <option value="referral">Refferal Earning (${{ auth()->user()->referral_wallet_balance }})</option>
                                        @endif
                                        @if(auth()->user()->medals_wallet_balance >= \App\Models\Setting::first()->value('advert_price'))
                                        <option value="medal">Medals Wallet (${{ auth()->user()->medals_wallet_balance }})</option>
                                        @endif
                                        <option value="coinbase">Pay with coinbase</option>
                                    </select>
                                </fieldset>
                                <input type="hidden" value="3" name ="type">
                               <br>
                                <div class="login-btn-inner">
                                    <div>
                                        <button style="width: 100%;"
                                            class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                            onclick="return confirm('Are you sure?');"  type="submit">Pay for Advert Placement</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
