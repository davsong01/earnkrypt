
@extends('layouts.auth')
@section('title', 'Earnkrypt - Create Account')
@section ('body')
 <form method="POST" action="{{ route('register') }}">
   @csrf
    <div style="background:white; text-align:center; margin-bottom:15px" class="card-header">
        <p style="color:black">Register to begin your experience</p>
    </div>
    <div class="row">
      <div class="col-12">
          <div class="wrap-input100 m-b-23">
            <span class="label-input100">Full Name</span>
            <input class="input100" type="text" name="name" value="{{ old('name') }}" required placeholder="Enter your name">
            <span class="focus-input100" data-symbol="&#xf206;"></span>
          </div>
      </div>
      <div class="col-12">
        <div class="wrap-input100 m-b-23">
          <span class="label-input100">Email</span>
          <input class="input100" type="text" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
          <span class="focus-input100" required data-symbol="&#9993;"></span>
        </div>
      </div>
      <div class="col-6">
        <div class="wrap-input100 m-b-23">
          <span class="label-input100">Username</span>
          <input class="input100" type="text" name="username" value="{{ old('username') }}" placeholder="Enter your username">
          <span class="focus-input100" data-symbol="&#xf206;"></span>
        </div>
      </div>
      <div class="col-6">
        <div class="wrap-input100 m-b-23">
          <span class="label-input100">Phone Number</span>
          <input class="input100" type="text" name="phone" value="{{ old('phone') }}" re
          quired placeholder="Enter your phone">
          <span class="focus-input100" required data-symbol="&#9742;"></span>
        </div>
    </div>
    </div>
    <div class="row">
     
      <div class="col-12">
        <div class="wrap-input100 m-b-23">
          <span class="label-input100">Enter referral code (Leave blank if none)</span>
          <input class="input100" type="text" name="my_upline" value="{{ old('my_upline') ?? request()->get('ref') }}" placeholder="Enter referral username">
          <span class="focus-input100" required data-symbol="&#xf206;"></span>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-12">
        <div class="wrap-input100">
          <span class="label-input100">Password</span>
          <input class="input100" type="password" id="password" name="password" value="{{ old('password') }}" required placeholder="Enter your password">
          <span class="focus-input100" required data-symbol="&#xf190;"></span>
        </div>
        <div class="m-b-23">
          <small onclick="oldFunction()">
            &nbsp &nbsp &nbsp &nbsp  <input type="checkbox" id="check" > Show password
          </small>
        </div>
      </div>  
      <div class="col-12">
        <div class="wrap-input100">
          <span class="label-input100">Confirm Password</span>
          <input class="input100" type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" required placeholder="Enter your password again">
          <span class="focus-input100" required data-symbol="&#xf190;"></span>
        </div>
        <div class="m-b-23">
          <small onclick="newFunction()">
            &nbsp &nbsp &nbsp &nbsp  <input type="checkbox" id="check2" > Show password
          </small>
        </div>
      </div>
    </div>                           
    <div class="row">
      <div class="col-12">
        <div class="container-login100-form-btn">
          <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button class="login100-form-btn">
              Register
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  {{-- <div class="row">
    <div class="col-12">
      <div class="txt1 text-center p-t-10 p-b-20">
        <span>
          Or Sign Up Using
        </span>
      </div>
      <div class="flex-c-m">
        <a href="{{ route('social.oauth', 'facebook') }}" class="login100-social-item bg1">
          <i class="fa fa-facebook"></i>
        </a>
    
        <a href="{{ route('social.oauth', 'google') }}" class="login100-social-item bg3">
          <i class="fa fa-google"></i>
        </a>
      </div>
      <hr>
      <div class="text-center"><a href="/login"><small class="mr-25">SIGN IN</small></a></div>
    </div>
  </div> --}}
  

  <script>
    function newFunction() {
        var x = document.getElementById("password_confirmation");
        var c = document.getElementById("check2");
        
        if (x.type === "password") {
            x.type = "text";
            c.checked="checked";
        } else {
            x.type = "password";
            c.checked="";
        }
        
    } 

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

@endsection
