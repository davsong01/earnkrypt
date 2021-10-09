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
                            <a class="nav-link nav-link-extra" href="{{ route('profile.edit', auth()->user()->id) }}">GENERAL</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link nav-link-extra" href="{{ route('profile.billing') }}">BILLING</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profile.security') }}">SECURITY</a>
                            </li>
                        </ul>
                        @include('layouts.alerts')
                        
                    </div>
                    <form action="{{ route('security.save') }}" method="POST" enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('patch')
                    <div class="row">
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-header">
                                Change Password
                            </div>
                            
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Enter old password</label>
                                    <input type="password" class="form-control" name="oldpassword" id="oldpassword" value="{{ old('oldpassword') }}">

                                    <p onclick="oldFunction()">
                                        <input type="checkbox" id="check" > &nbsp show old password
                                    </p>
                    
                                </div>
                                <script>
                                    function oldFunction() {
                                        var x = document.getElementById("oldpassword");
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

                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Enter new password</label>
                                    <input type="password" class="form-control" name="newpassword" id="newpassword" value="{{ old('newpassword') }}">

                                    <p onclick="newFunction()">
                                        <input type="checkbox" id="check2" > &nbsp show new password

                                    </p>
                        
                                   
                                </div>
                                <script>
                                    function newFunction() {
                                        var x = document.getElementById("newpassword");
                                        var c = document.getElementById("check2");
                                        
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

