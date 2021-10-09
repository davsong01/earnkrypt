@extends('layouts.auth')
@section('title', 'Earnkrypt - Reset Password')
	@section ('body')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="wrap-input100 m-b-23">
            <span class="label-input100">Email</span>
            <input class="input100" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>
        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button class="login100-form-btn">
                Send Password reset link
              </button>
            </div>
          </div>

    </form>
  @endsection

