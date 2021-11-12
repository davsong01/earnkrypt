@extends('backend.layouts.admin')
@section('title', 'Update Settings')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-title">
                @include('layouts.alerts')
        </div>
        <form action="{{ route('setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Referral Percentage</label>
                        <input type="number" class="form-control" name="referral_percent" required
                            value="{{ old('name') ?? $setting->referral_percent}}">
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group-inner">
                            <label>Advert Referral Percentage</label>
                            <input type="number" class="form-control" name="advert_referral_percent" required
                                value="{{ old('advert_referral_percent') ?? $setting->advert_referral_percent}}">
                        </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Official Email</label>
                        <input type="email" class="form-control" name="official_mail" required
                            value="{{ old('official_mail') ?? $setting->official_mail}}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Official Wallet Address</label>
                        <input type="text" class="form-control" name="official_wallet" required
                            value="{{ old('official_wallet') ?? $setting->official_wallet}}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Payment delay(minutes)</label>
                        <input type="number" class="form-control" name="payment_delay" required
                            value="{{ old('payment_delay') ?? $setting->payment_delay }}">
                    </div>
                </div>
            
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Advert Email Address</label>
                        <input type="text" class="form-control" name="advert_email" required
                            value="{{ old('advert_email') ?? $setting->advert_email}}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Advert price ($)</label>
                        <input type="text" class="form-control" name="advert_price" required
                            value="{{ old('advert_price') ?? $setting->advert_price }}">
                    </div>
                 </div>
               
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="basic-login-inner">
                            <label>Design Ordering Email Address</label>
                            <input type="text" class="form-control" name="design_email" required
                                value="{{ old('design_email') ?? $setting->design_email }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Logo design ($)</label>
                        <input type="text" class="form-control" name="logo_price" required
                            value="{{ old('logo_price') ?? $setting->logo_price }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Minimum amount for withdrawal ($)</label>
                        <input type="number" class="form-control" name="withdrawal_threshold" required
                            value="{{ old('withdrawal_threshold') ?? $setting->withdrawal_threshold }}" step=".01">
                    </div>
                </DIV>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Flier design price ($)</label>
                        <input type="text" class="form-control" name="flier_price" required
                            value="{{ old('flier_price') ?? $setting->flier_price }}">
                    </div>
                </DIV>
                {{-- <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Flier design coinbase payment link</label>
                        <input type="url" class="form-control" name="flier_payment_link" required
                            value="{{ old('flier_payment_link') ?? $setting->flier_payment_link }}">
                    </div>
                </DIV> --}}
                    
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Graphics Video price ($)</label>
                        <input type="text" class="form-control" name="graphics_video_price" required
                            value="{{ old('graphics_video_price') ?? $setting->graphics_video_price }}">
                    </div>
                </div>
                {{-- <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Graphics Video coinbase payment link</label>
                        <input type="url" class="form-control" name="graphics_video_payment_link" required
                            value="{{ old('graphics_video_payment_link') ?? $setting->graphics_video_payment_link }}">
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Replace Site Logo</label> <br> <x-logo></x-logo>
                        <input type="file" class="form-control" name="sitelogo"
                            value="{{ old('logo')}}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group-inner">
                        <label>Replace Favicon</label> <br> <img src="{{ asset('images/site/' . \App\Models\Setting::first()->value('favicon')) }}" alt="favicon" style="max-width:40px">
                        <input type="file" class="form-control" name="sitefavicon"
                            value="{{ old('favicon')}}">
                    </div>
                </div>
                    
            </div>

            <div class="row">
                <div class="col-12">
                <div class="login-btn-inner">
                    <div>
                        <button style="width: 100%; margin-top:10px" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                            type="submit">Update Settings</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

