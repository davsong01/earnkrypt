@extends('backend.layouts.admin')
@section('title', 'Edit transaction')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('transaction.update', $transaction->id) }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('patch')
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Reference Id</label>
                                    <input type="reference" class="form-control" name="reference" required
                                        value="{{ old('reference') ?? $transaction->reference}}">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="login-btn-inner">
                            <div>
                                <button style="width: 100%;" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                    type="submit">Update transaction</button>
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

