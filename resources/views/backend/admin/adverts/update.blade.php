@extends('backend.layouts.admin')
@section('title', 'Update withdrawal request')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('withdraw.update', $withdrawal->id) }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Date Requested</label>
                                        <input type="text" disabled class="form-control" value="{{ $withdrawal->created_at->format('Y-m-d, h:i:s A') }}">
                                    </div>
                                </div>
                                @if($withdrawal->date_paid)
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Date Paid</label>
                                        <input type="text" disabled class="form-control" value="{{ $withdrawal->date_paid}}">
                                    </div>
                                </div>
                                @endif
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Username</label>
                                        <input type="text" class="form-control" disabled value="{{ $withdrawal->user->username }}">
                                    </div>
                                </div>
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Bitcoin Wallet Address</label>
                                        <input type="text" class="form-control" value="{{ $withdrawal->user->wallet_address }}">
                                    </div>
                                </div>
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>ETH Wallet Address</label>
                                        <input type="text" class="form-control" value="{{ $withdrawal->user->eth_wallet_address }}">
                                    </div>
                                </div>
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>LTC Wallet Address</label>
                                        <input type="text" class="form-control" value="{{ $withdrawal->user->ltc_wallet_address }}">
                                    </div>
                                </div>
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>BNB Wallet Address</label>
                                        <input type="text" class="form-control" value="{{ $withdrawal->user->bnb_wallet_address }}">
                                    </div>
                                </div>
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Amount Requested ($)</label>
                                        <input type="text" class="form-control" disabled value="{{ $withdrawal->amount }}">
                                    </div>
                                </div>
                                
                                <div class="basic-login-inner">
                                    
                                    <div class="basic-login-inner">
                                        <div class="form-group-inner form-group">
                                            <label>Paid</label>
                                            <select name="paid" id="paid" class="form-control" required>
                                                <option value="0" {{ $withdrawal->paid == '0' ? 'selected' : '' }}>
                                                    No</option>
                                                <option value="1"
                                                    {{$withdrawal->paid == '1' ? 'selected' : '' }}>
                                                    Yes</option>
                                            </select>

                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $withdrawal->id }}" name="id">
                                </div><br>
                                <div class="login-btn-inner">
                                    <div>
                                        <button style="width: 100%;"
                                            class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                            type="submit">Update request</button>
                                    </div>
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
