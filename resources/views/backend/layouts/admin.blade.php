<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <div id="fb-root"></div>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    
    <x-favicon></x-favicon>
    <title>{{ config('app.name') }} - @yield('title')</title>
    {{-- New Styles --}}
    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
 

    <!-- Custom CSS -->
    <link href="{{ asset('admin/assets/libs/flot/css/float-chart.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/extra-libs/multicheck/multicheck.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    
    <link href="{{ asset('admin/dist/css/style.min.css') }}" rel="stylesheet">
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://commerce.coinbase.com/v1/checkout.js">
    </script>
    
    <style>
        .wallet {
            color:green;
        }
        .navbar-brand img {
            width: 60px;
            display: flex;
        }
        .card{
            padding-bottom: 20px;
        }
        .create{
            padding: 10px;
            font-size: 14px;
        }
        .edit{
            padding: 10px;
        }
    </style>
    @yield('styles')
</head>

<body>
    
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
  
    <div id="main-wrapper">
       
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                   
                    <a class="navbar-brand" href="/" style="width: 80%;">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <x-logo></x-logo>                           
                        </b>
                        <!--End Logo icon -->

                    </a>
                  
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
               
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                   
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    
                    </ul>
                   
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <strong>Howdy, </strong> {{ auth()->user()->name }}
                            </a>
                             
                        </li>
                        @if(auth()->user()->user_types == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <strong> Wallet Balance:</strong> ${{ auth()->user()->wallet_balance +  auth()->user()->referral_wallet_balance +  auth()->user()->medals_wallet_balance}} USD
                            </a>
                             
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic rounded-circle" href="{{ route('profile.edit', auth()->user()->id) }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">   
                                <img class="mr-1" style="border-radius:50%" src="{{ asset(auth()->user()->avatar ? 'uploads/'.auth()->user()->avatar : 'uploads/avatars/default.jpg') }}" alt="avatar" height="40" width="40">
                                                            
                            </a>
                          
                        </li>
                        @endif
                        @if(auth()->user()->user_types == 2 || auth()->user()->user_types == 3)
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic rounded-circle" href="{{ route('admins.edit', auth()->user()->id) }}">   
                        <li class="nav-item">
                              <img class="mr-1" style="border-radius:50%" src="{{ asset(auth()->user()->avatar ? 'uploads/'.auth()->user()->avatar : 'uploads/avatars/default.jpg') }}" alt="avatar" height="40" width="40">
                        </li>
                        </a>
                        @endif
                      
                    </ul>
                </div>
            </nav>
        </header>

        @include('backend.layouts.navigation')

        <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">@yield('title')</h4>
                    {{-- <div class="ml-auto text-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                            </ol>
                        </nav>
                    </div> --}}
                </div>
            </div>
        </div>
        
        @yield('content')
        </div>
        <footer class="footer text-center">
             All Rights Reserved. &copy;{{ date('Y') }}.<a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.
        </footer>
    </div>
    
    {{-- <script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script> --}}
    <!-- Bootstrap tether Core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script> --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    {{-- <script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('admin/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('admin/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('admin/dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!-- <script src="{{ asset('admin/dist/js/pages/dashboards/dashboard1.js') }}"></script> -->
    <!-- Charts js Files -->
    <script src="{{ asset('admin/assets/libs/flot/excanvas.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/pages/chart/chart-page-init.js') }}"></script>
     {{-- <script src="{{ asset('admin/extra-libs/multicheck/datatable-checkbox-init.js')}}"></script> --}}
    {{-- <script src="{{ asset('admin/extra-libs/multicheck/jquery.multicheck.js')}}"></script> --}}
   
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>


    <script>
        $('#zero_config').DataTable();
    </script>

</body>

</html>