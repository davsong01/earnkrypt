@extends('backend.layouts.admin')
@section('title', 'Account')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profile.edit', auth()->user()->id) }}">GENERAL</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link nav-link-extra" href="{{ route('profile.billing') }}">BILLING</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link nav-link-extra" href="{{ route('profile.security') }}">SECURITY</a>
                            </li>
                        </ul>
                        @include('layouts.alerts')
                        
                    </div>
                    <form action="{{ route('profile.update', $user->id) }}" method="POST" onsubmit="return confirm('Kindly ensure that you have filled your correct information?');"  enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('patch')
                    <div class="row">
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-header">
                                <div class="col-md-1 col-sm-1">
                                    <img src="{{'/uploads/' .$user->avatar }}" id="avatar" width="40px" style=" display: block; margin-left: auto;
                                    margin-right: auto; width: 50%;border-radius: 50%; width:50px;height:50px;margin-right:15px; float: left;" alt="Profile Picture">
                                </div>
                                <div class="col-md-10 col-sm-10">
                                    
                                   <strong> {{ $user->name }}</strong> <br>
                                   <p>{{'@'.$user->username}}</p>
                                     
                                </p>
                            </div>
                        </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label class="wallet">Main Wallet</label>
                                    <input type="number" class="form-control" disabled placeholder="${{ $user->wallet_balance}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label class="wallet">Refferal Earnings</label>
                                    <input type="number" class="form-control" disabled placeholder="${{ $user->referral_wallet_balance}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label class="wallet">Medal Earnings</label>
                                    <input type="number" class="form-control" disabled placeholder="${{ $user->medals_wallet_balance}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Full name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') ?? $user->name}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone"
                                        value="{{ old('phone') ?? $user->phone}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required
                                        value="{{ old('email') ?? $user->email}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Bitcoin Wallet Address</label>
                                    <input type="text" class="form-control" name="wallet_address" required
                                        value="{{ old('wallet_address') ?? $user->wallet_address}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Etherum Wallet Address</label>
                                    <input type="text" class="form-control" name="eth_wallet_address" required
                                        value="{{ old('eth_wallet_address') ?? $user->eth_wallet_address}}">
                                </div>
                            </div>

                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Litecoin Wallet Address</label>
                                    <input type="text" class="form-control" name="ltc_wallet_address" required
                                        value="{{ old('ltc_wallet_address') ?? $user->ltc_wallet_address}}">
                                </div>
                            </div>

                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Binance Coin</label>
                                    <input type="text" class="form-control" name="bnb_wallet_address" required
                                        value="{{ old('bnb_wallet_address') ?? $user->bnb_wallet_address}}">
                                </div>
                            </div>
                            
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Account Type</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $user->plans->title}}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Membership Ends</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ \Carbon\Carbon::parse($user->plan_expiry)->toDayDateTimeString() }}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Change Profile Picture (Image files of not more than 1mb)</label>
                                    <input type="file" class="form-control" name="avatar" value="{{ old('avatar') ?? $user->avatar }}" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <div class="login-btn-inner">
                            <div>
                                <button style="width: 100%; margin-top:10px" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                    type="submit">Update</button>
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

