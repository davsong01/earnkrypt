
@extends('layouts.auth')
@section('title', 'Earnkrypt - Login')
	@section ('body')
 <form method="POST" action="{{ route('login') }}">
   @csrf
  <div class="wrap-input100 m-b-23">
    <span class="label-input100">Email</span>
    <input class="input100" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
    <span class="focus-input100" data-symbol="&#xf206;"></span>
  </div>

  <div class="wrap-input100">
    <span class="label-input100">Password</span>
    <input class="input100" type="password" name="password" id="password" placeholder="Type your password">
    <span class="focus-input100" data-symbol="&#xf190;"></span>
    
  </div>
  <div>
    <small onclick="newFunction()">
      &nbsp &nbsp &nbsp &nbsp  <input type="checkbox" id="check" > Show password
    </small>
  </div>
  
  <script>
    function newFunction() {
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
  
   @if (Route::has('password.request'))
   <div class="text-right p-t-8 p-b-31">
    <a class="btn btn-link" href="{{ route('password.request') }}" style="font-size: 12px;">
      Forgot password?
    </a>
  </div>
  @endif
                                
  
  <div class="container-login100-form-btn">
    <div class="wrap-login100-form-btn">
      <div class="login100-form-bgbtn"></div>
      <button class="login100-form-btn">
        Login
      </button>
    </div>
  </div>

  </form>
  {{-- <div class="txt1 text-center p-t-10 p-b-20">
    <span>
      Or Sign In Using
    </span>
  </div> --}}

  {{-- <div class="flex-c-m">
    <a href="{{ route('social.oauth', 'facebook') }}" class="login100-social-item bg1">
      <i class="fa fa-facebook"></i>
    </a>
    <a href="{{ route('social.oauth', 'google') }}" class="login100-social-item bg3">
      <i class="fa fa-google"></i>
    </a>
  </div> --}}
  <hr>
  <div class="text-center"><a href="/register"><small class="mr-25">CREATE AN ACCOUNT</small></a></div>

  @endsection
