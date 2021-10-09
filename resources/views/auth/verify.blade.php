@extends('layouts.auth')
@section('title', 'Earnkrypt - Create Account')
@section('body')

<form method="POST" action="{{ route('register') }}">
    @csrf
     <div style="text-align:center; margin-bottom:15px" class="card-header">
         <p style="color:black">
            @if (session('resent'))
            {{ session('email') }}
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to:') }}
                </div>
            @endif
        </p>
     </div>
     <div class="row">

           <div class="card-body">
            <div style="text-align:center; margin-bottom:15px" class="card-header">
                <p style="color:black">  {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},</p>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="login100-form-btn">
                    {{ __('click here to request another') }}
                    </button>

                </form>
     
        </div>
       </div>
     </div>
 
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    
 
                  
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
