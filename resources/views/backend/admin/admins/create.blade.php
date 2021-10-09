@extends('backend.layouts.admin')
@section('title', 'New subscriber')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('admins.store') }}" method="POST"
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
                                     <div class="form-group-inner">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" required
                                            value="{{ old('username') }}">

                                    </div>
                                        <div class="form-group-inner">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" required
                                                value="{{ old('email') }}">

                                        </div>
                                        <div class="form-group-inner">
                                            <label>Phone</label>
                                            <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                        </div>
                                        <div class="basic-login-inner">
                                            <div class="form-group-inner">
                                                <label>Avatar (Image files of not more than 1mb)</label>
                                                <input type="file" class="form-control" name="avatar" value="{{ old('avatar') }}" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="form-group-inner">
                                            <label>Password (Optional, <b>default password is Earnkrypt2000</b>)</label>
                                            <input type="password" class="form-control" name="password"
                                                value="{{ old('password') }}">
                                        </div>
                                    </div>
                                  
                                    <br>
                                    <div class="login-btn-inner">
                                        <div>
                                            <button style="width: 100%;"
                                                class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                                type="submit">Save</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

@endsection
