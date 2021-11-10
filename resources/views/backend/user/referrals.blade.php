@extends('backend.layouts.admin')
@section('title', 'Referrals')
@section('content')
@section('styles')
<style>
    .our-team{ text-align: center; }
    .our-team .pic{
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        width: 50%;
        margin: auto;
    }
    .our-team .pic:before,
    .our-team .pic:after{
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 13px solid #e6e5e5;
        position: absolute;
        top: 0;
        left: 0;
    }
    .our-team .pic:after{
        border-color: #ffd565 #e6e5e5 #e6e5e5 #ffd565;
        z-index: 1;
        transform: rotate(-10deg);
        transition: all 0.5s ease 0s;
    }
    .our-team:hover .pic:after{ transform: rotate(350deg); }
    .our-team img{
        width: 100%;
        height: auto;
    }
    .our-team .title{
        font-size: 26px;
        font-weight: bold;
        color: #222;
        padding-bottom: 10px;
        margin: 15px 0 10px 0;
        position: relative;
    }
    .our-team .title:after{
        content: "";
        width: 30px;
        height: 2px;
        background: #222;
        margin: 0 auto;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .our-team .post{
        display: block;
        font-size: 16px;
        font-style: italic;
        color: #777;
    }
    .our-team .icon{
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0;
    }
    .our-team .icon li{ display: inline-block; }
    .our-team .icon li a{
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        background: #e0e0e0;
        font-size: 14px;
        color: #999;
        margin-right: 5px;
        transition: all 0.3s ease-out 0s;
    }
    .our-team .icon li a:hover{
        background: #ffd565;
        color: #fff;
    }
    @media only screen and (max-width: 990px){
        .our-team{ margin-bottom: 30px; }
    }
</style>
@endsection
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                         @if($referralss->count() <= 0)
                        <div class=" text-center">
                            <img src="{{ asset('images/champagne.jpg') }}" alt="" style="width:80px; border-radius: 50%;"><br><br>
                            <p> No referrals, yet. Earn a 5% commission on the first membership payments made by friends you refer.</p>
                            @endif
                            <p><strong>Your referral code is: {{ auth()->user()->username }}</strong> 
                            <button style="border-radius: 10%;" class="btn btn-info btn-lg" onclick="myFunction()">Copy link</button>
                            <input  style="color: #faebd700;background: #fff0; border: #fff0;" type="text" value="{{ config('app.url').'register?ref='. auth()->user()->username }}" id="myInput" >
                        </p>
                        </div>

                        <script>
                            function myFunction() {
                                var copyText = document.getElementById("myInput");
                                copyText.select();
                                copyText.setSelectionRange(0, 99999)
                                document.execCommand("copy");
                                copyText.style.visibility = 'hidden';
                                alert("Referral link copied!");
                            }
                        </script>
                    
                    @if($referralss->count() > 0)
                    <div class="container-fluid">
                        <!-- Refferals start-->
                        <div class="row">
                            <div class=" text-center">
                                <h4><strong>YOUR DOWNLINES </strong> <br><br><br>
                                </h4>
                            </div>
                            @foreach($referralss as $referrals)
                            <div class="col-md-3 col-sm-6">
                                <div class="our-team">
                                    <div class="pic"><img src="{{asset( $referrals->avatar ? 'uploads/'. $referrals->avatar : 'uploads/avatars/default.jpg') }}" alt=""></div>
                                    <h3 class="title">{{ $referrals->username }}</h3>
                                    <span class="post"> {{ isset($referrals->plans) ? $referrals->plans->title : 'No Plan yet' }}</span>
                                    <span @if(!isset($referrals->plans)) style="color:red" @endif)> Joined: <small>{{ $referrals->created_at->format('Y-m-d') }} </small></span>
                                </div>
                            </div>
                            @endforeach
                    
                        </div>
                        <!--Referrals end-->
                
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
