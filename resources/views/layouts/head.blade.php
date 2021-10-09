<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ config('app.name') }}, Social media content growth">
    <meta name="keywords" content="{{ config('app.name') }}, Social media, content growth">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- SITE TITLE -->
    <title>{{ config('app.name') }} - Social media content growth</title>

    <!-- =========================
        FAV AND TOUCH ICONS  
    ============================== -->
    <x-favicon></x-favicon>
    {{-- <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/logo.png') }}"> --}}

    <!-- =========================
        STYLESHEETS   
    ============================== -->
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- FONT ICONS -->
    <link rel="stylesheet" href="{{ asset('assets/elegant-icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/app-icons/styles.css') }}">

    <!-- WEB FONTS -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,100italic,400,300italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CAROUSEL AND LIGHTBOX -->
    <link rel="stylesheet" href="{{ asset('css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nivo-lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nivo_themes/default/default.css') }}">

    <!-- ANIMATIONS -->
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">

    <!-- CUSTOM STYLESHEETS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- COLORS -->
    <link rel="stylesheet" href="{{ asset('css/colors/blue.css') }}">
    
    <!-- RESPONSIVE FIXES -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <style>
        .navbar-header {
            height: 90px;
        }
    </style>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</head>