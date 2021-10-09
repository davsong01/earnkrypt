@extends('backend.layouts.admin')
@section('title', 'New Plan')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('plans.store') }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" required
                                            value="{{ old('title') }}">

                                    </div>
                                    <div class="basic-login-inner">
                                        <div class="form-group-inner">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" name="amount" required
                                                value="{{ old('amount') }}">
                                        </div>
                                        <div class="form-group-inner">
                                            <label>Promotion Commision (%)</label>
                                            <input type="number" class="form-control" name="commission" required
                                                value="{{ old('commission') }}">
                                        </div>
                                        <div class="form-group-inner">
                                            <label>Return ($)</label>
                                            <input type="number" class="form-control" name="return" required
                                                value="{{ old('return') }}">
                                        </div>
                                        <div class="form-group-inner">
                                            <label>Daily Return ($)</label>
                                            <input type="number" class="form-control" name="daily_returns" required
                                                value="{{ old('daily_returns') }}">
                                        </div>
                                       
                                        <div class="form-group-inner">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" rows="12" required
                                                value="{{ old('description') }}"></textarea>

                                        </div>

                                        <div class="form-group-inner">
                                            <label>Payment Embed URL (Get from coinbase dashboard)</label>
                                            <input type="text" class="form-control" name="payment_link" required
                                                value="{{ old('payment_link') }}" required>
                                        </div>
                                        <div class="login-btn-inner">
                                            <div>
                                                <button style="width: 100%;"
                                                    class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                                    type="submit">Save Plan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    
                                </div>

                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

@endsection
