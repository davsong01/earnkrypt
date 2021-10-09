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
                    <form action="{{ route('admins.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" required
                                        value="{{ old('name') ?? $user->name}}">
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" disabled>
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required
                                        value="{{ old('email') ?? $user->email}}">
                            </div>
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Change Avatar (Image files of not more than 1mb)</label>
                                    <input type="file" class="form-control" name="avatar" value="{{ old('avatar') ?? $user->avatar}}" accept="image/*">
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
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <div class="login-btn-inner">
                            <div>
                                <button style="width: 100%; margin-top:10px" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                    type="submit">Update Admin</button>
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

