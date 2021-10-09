@extends('backend.layouts.admin')
@section('title', 'Edit: '.$plan->title)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('plans.update', $plan->id) }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('patch')
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" required
                                        value="{{ old('title') ?? $plan->title}}">

                            </div>
                        </div>

                        <div class="basic-login-inner">
                            <div class="form-group-inner">
                                <label>Amount ($)</label>
                                <input type="number" class="form-control" name="amount" required
                                    value="{{ old('amount') ?? $plan->amount }}" step="0.01">
                            </div>
                            <div class="form-group-inner">
                                <label>Withdrawal Commission (%)</label>
                                <input type="number" class="form-control" name="commission" required
                                    value="{{ old('commission') ?? $plan->commission }}" step="0.01">
                            </div>
                            <div class="form-group-inner">
                                <label>Return ($)</label>
                                <input type="number" class="form-control" name="return" required
                                    value="{{ old('return') ?? $plan->return }}" step="0.01">
                            </div>
                            <div class="form-group-inner">
                                <label>Daily Return ($)</label>
                                <input type="number" class="form-control" name="daily_returns" required
                                    value="{{ old('daily_returns') ?? $plan->daily_returns }}" step="0.01">
                            </div>
                            <div class="form-group-inner">
                                <label>Coin Base Payment Link</label>
                                <input type="text" class="form-control" name="payment_link" required
                                    value="{{ old('payment_link') ?? $plan->payment_link}}">
                            </div>
                            <div class="form-group-inner">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="12" required
                                    value="{{ old('description') ?? $plan->description }}">{{ old('description') ?? $plan->description }}</textarea>

                            </div>
                            <br>
                        </div>

                        
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="login-btn-inner">
                            <div>
                                <button style="width: 100%;" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                    type="submit">Update plan</button>
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

