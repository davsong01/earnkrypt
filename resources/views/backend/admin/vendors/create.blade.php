@extends('backend.layouts.admin')
@section('title', 'New vendor')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('vendor.store') }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" required
                                            value="{{ old('name') }}">

                                    </div>
                                    <div class="basic-login-inner">
                                        <div class="form-group-inner">
                                            <label>Whatsapp Phone Number(in international format)</label>
                                            <input type="text" class="form-control" name="phone" placeholder="e.g. +2348180010243" required
                                                value="{{ old('phone') }}">
                                        </div>
                                       
                                        <div class="form-group-inner">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" 
                                                value="{{ old('email') }}">
                                        </div> <br>
                                        <div class="login-btn-inner">
                                            <div>
                                                <button style="width: 100%;"
                                                    class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                                    type="submit">Save vendor</button>
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

@endsection
