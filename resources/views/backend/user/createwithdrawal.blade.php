@extends('backend.layouts.admin')
@section('title', 'Create Withdrawal')
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
                            <h5>Your Wallet Balance: ${{ auth()->user()->wallet_balance }}</h5>
                            <h5>Your Refferal Earnings: ${{ auth()->user()->referral_wallet_balance }}</h5>
                            <h5>Your medals Earnings: ${{ auth()->user()->medals_wallet_balance }}</h5>
                            <br>
                            <h6>Please note the following: <br>
                            
                            </h6>
                            <p>Please note that we transaction fees will be deducted from this amount <br>
                            <ol>
                                <li>Ensure that you have filled in your wallet addresses</li>
                                <li>You can only withdraw once a month from your main wallet</li>
                                <li>The coin equivalent of amount requested will be paid</li>
                                <li>Commision of {{ auth()->user()->plans->commission }}% applies to this transaction if you are withdrawing from main wallet</li>
                            </ol>
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('withdraw.store') }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <fieldset class="form-group">
                                    <label for="wallet">Select Wallet to withdraw from</label>
                                    <select class="form-control" name="wallet" id="wallet" required>
                                        <option selected value="">Select Option</option>
                                        @if(auth()->user()->withdraw() < 1)
                                        <option value="wallet">Main Wallet</option>
                                        @endif
                                        <option value="referral">Refferal Earning</option>
                                        <option value="medal">Medals Wallet</option>
                                    </select>
                                </fieldset>

                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Amount to Withdraw($)  </label>
                                        <input type="number" class="form-control" id="amount" name="amount"  required
                                            value="{{ old('amount') }}" step=".01" min=0>
                                    </div>
                                </div>
                               
                               <br>
                                <div class="login-btn-inner">
                                    <div>
                                        <button style="width: 100%;"
                                            class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                            onclick="return confirm('You are about to withdraw');"  type="submit">Request Withdrawal</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#wallet').on('change', function(){

        $('#amount').html('');

        if($('#wallet').val()=='wallet'){

            $("#amount").attr({
                "max" :"{{ $available_in_wallet }}",
                "placeholder":"{{ $available_in_wallet }}"
            });
            $('#amount').html('');

        }if($('#wallet').val()=='referral'){
            $("#amount").attr({
                "max" :"{{ auth::user()->referral_wallet_balance }}",
                "placeholder":"{{ auth::user()->referral_wallet_balance }}"
            });
            $('#amount').html('');
        }
        if($('#wallet').val()=='medal'){
            $("#amount").attr({
                "max" :"{{ auth::user()->medals_wallet_balance }}",
               "placeholder":"{{ auth::user()->medals_wallet_balance }}"
            });

        }
       
    });
</script>
@endsection
