<!-- =========================
     HEADER   
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="home">
    <!-- COLOR OVER IMAGE -->
    <div class="color-overlay"> <!-- To make header full screen. Use .full-screen class with color overlay. Example: <div class="color-overlay full-screen">  -->

         <!-- STICKY NAVIGATION -->
         <div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- LOGO ON STICKY NAV BAR -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#kane-navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="front-logo">
                      <x-logo></x-logo>  
                    </div>
                    
                    {{-- <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt=""></a> --}}

                </div>

                <!-- NAVIGATION LINKS -->
                <div class="navbar-collapse collapse" id="kane-navigation">
                    <ul class="nav navbar-nav navbar-right main-navigation">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        @guest
                        <li><a href="/login">Sign in</a></li>
                        <li><a href="/register">Create Account</a></li>  
                        @endguest
                        @auth
                        <li><a href="/dashboard">My Account</a></li>  
                        @endauth
                        
                    </ul>
                </div>
            </div>
        </div>
        <!-- CONTAINER -->
        <div class="container">
            
            <!-- ONLY LOGO ON HEADER -->
            <div class="only-logo">
                <div class="navbar">
                    <div class="navbar-header">
                        {{-- <img src="{{ asset('images/logo.png')}}" alt=""> --}}
                    </div>
                </div>
            </div> <!-- /END ONLY LOGO ON HEADER -->
            
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    
                    <!-- HEADING AND BUTTONS -->
                    <div class="intro-section">
                        
                        <!-- WELCOM MESSAGE -->
                        <h1 style="font-weight:bold" class="intro">Grow your social media content with Earnkrypt</h5>
                        
                        <!-- BUTTON -->
                        <div class="buttons" id="download-button">
                            
                            <a href="{{route('login')}}" class="btn btn-default btn-lg standard-button"><i class="icon-app-download"></i>Sign In</a>
                            <a href="{{route('register')}}" class="btn btn-default btn-lg standard-button"><i class="icon-app-download"></i>Register</a>
                            
                        </div>
                        <!-- /END BUTTONS -->
                        
                    </div>
                    <!-- /END HEADNING AND BUTTONS -->
                    
                </div>
            </div>
            <!-- /END ROW -->
            
        </div>
        <!-- /END CONTAINER -->
    </div>
    <!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->