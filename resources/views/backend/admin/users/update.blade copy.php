@extends('backend.layouts.admin')
@section('title', 'Edit: '.$user->name)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('user.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('patch')
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            {{-- <div class="basic-login-inner"> --}}
                                <div class="form-group-inner">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" required
                                        value="{{ old('name') ?? $user->name}}">
                            {{-- </div> --}}
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            {{-- <div class="basic-login-inner"> --}}
                                <div class="form-group-inner">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" required
                                        value="{{ old('username') ?? $user->username}}">
                            {{-- </div> --}}
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required
                                        value="{{ old('email') ?? $user->email}}">
                            </div>
                        </div>
                            {{-- <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Publishing Plan</label>
                                    <select class="form-control" name="publishing_plans_id" id="publishing_plans_id">
                                        <option value="">Select option</option>
                                        @foreach($plans as $plan)
                                        <option value="{{ $plan->id ?? old('publishing_plans_id')}}" {{ $user->publishing_plans_id == $plan->id ? 'selected' : ''}}>{{ $plan->title }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                            </div> --}}
                        
                            {{-- <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Wallet Balance</label>
                                    <input type="number" class="form-control" name="wallet_balance" required
                                        value="{{ old('wallet_balance') ?? $user->wallet_balance }}" step=".01">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Referral Wallet Balance</label>
                                    <input type="number" class="form-control" name="referral_wallet_balance" required
                                        value="{{ old('referral_wallet_balance') ?? $user->referral_wallet_balance }}" step=".01">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Medals Wallet Balance</label>
                                    <input type="number" class="form-control" name="medals_wallet_balance" required
                                        value="{{ old('medals_wallet_balance') ?? $user->medals_wallet_balance }}" step=".01">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Bitcoin Wallet Address</label>
                                    <input type="text" class="form-control" name="wallet_address"
                                        value="{{ old('wallet_address') ?? $user->wallet_address }}" >
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>ETH Wallet Address</label>
                                    <input type="text" class="form-control" name="eth_wallet_address"
                                        value="{{ old('eth_wallet_address') ?? $user->eth_wallet_address }}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>LTC Wallet Address</label>
                                    <input type="text" class="form-control" name="ltc_wallet_address"
                                        value="{{ old('ltc_wallet_address') ?? $user->ltc_wallet_address }}">
                                </div>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>BNB Wallet Address</label>
                                    <input type="text" class="form-control" name="bnb_wallet_address"
                                        value="{{ old('bnb_wallet_address') ?? $user->bnb_wallet_address }}">
                                </div>
                            </div>
                            <div class="form-group-inner">
                                <label>Reset Password (Optional)</b>)</label>
                                <input type="password" id="password" class="form-control" name="password"
                                    value="{{ old('password') }}">

                                    <p onclick="oldFunction()">
                                        <input type="checkbox" id="check" > &nbsp show password

                                    </p>
                                    <script>
                                        function oldFunction() {
                                            var x = document.getElementById("password");
                                            var c = document.getElementById("check");
                                            
                                            if (x.type === "password") {
                                                x.type = "text";
                                                c.checked="checked";
                                            } else {
                                                x.type = "password";
                                                c.checked="";
                                            }
                                            
                                        } 
                                    </script>
                            </div> --}}
                            
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <div class="login-btn-inner">
                            <div>
                                <button style="width: 100%; margin-top:10px" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                    type="submit">Update user</button>
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

