<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title')</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<x-favicon></x-favicon>

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login-files/css/main.css') }}">
<!--===============================================================================================-->
<style>
	.wrap-login100 {
    	width: 800px !important;
	}
	.small, small {
		font-size: 10px;
		font-weight: 200;		
	}
</style>
</head>
<body>
<div class="limiter">
<div class="container-login100" style="background-image: url('{{ asset('login-files/images/bg-01.jpg')}}');">
    <div class="wrap-login100 p-l-25 p-r-25 p-t-65 p-b-54">
            <span class="login100-form-title p-b-1">

                    <div style="text-align: center;">
					<a href="/"><x-logo></x-logo></a>
					</div>
            </span>
            
            @include('layouts.alerts')

            @yield('body')  
    </div>
</div>
  </div>
<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="{{ asset('login-files/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('login-files/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('login-files/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('login-files/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('login-files/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('login-files/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('login-files/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('login-files/vendor/countdowntime/countdowntime.js') }}"></script>
	<script src="{{ asset('login-files/js/main.js') }}"></script>

</body>
</html>