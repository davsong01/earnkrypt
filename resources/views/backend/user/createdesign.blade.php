@extends('backend.layouts.admin')
@section('title', 'Order for design')
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
                            <p>Hi {{ auth()->user()->username }}, you are eligible to order for services, please note services pricing plans below <br>
                                 <strong>Logo:</strong> ${{ \App\Models\Setting::first()->value('logo_price') }} <br>
                                 <strong>Flier:</strong> ${{ \App\Models\Setting::first()->value('flier_price') }} <br>
                                 <strong>Graphics Video:</strong> ${{ \App\Models\Setting::first()->value('graphics_video_price') }} <br>                         
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
                    <form action="{{ route('design.pay') }}" method="POST"
                        enctype="multipart/form-data" class="pb-2" target = "_blank">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <fieldset class="form-group">
                                    <label for="type">Select design type</label>
                                    <select class="form-control" name="variation" id="variation" required>
                                        <option value="">Select Option</option>
                                        <option value="logo">Logo design (${{ \App\Models\Setting::first()->value('logo_price') }})</option>
                                        <option value="flier">Flier design (${{ \App\Models\Setting::first()->value('flier_price') }})</option>
                                        <option value="graphics_video">Graphics Video (${{ \App\Models\Setting::first()->value('graphics_video_price') }})</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <fieldset class="form-group">
                                    <label for="payment_method">Select Wallet to withdraw from</label>
                                    <select class="form-control" name="payment_method" id="payment_method" required>
                                        <option value="">Select Option</option>
                                       
                                        <option value="wallet">Main Wallet (${{ auth()->user()->wallet_balance }} )</option>
                                       
                                        <option value="referral">Refferal Earning (${{ auth()->user()->referral_wallet_balance }})</option>
                                        
                                        <option value="medal">Medals Wallet (${{ auth()->user()->medals_wallet_balance }})</option>
                                       
                                        <option value="coinbase">Pay with coinbase</option>
                                    </select>
                                </fieldset>
                            </div>
                           <input type="hidden" value="2" name="type">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
