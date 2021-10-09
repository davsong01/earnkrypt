<header class="header" data-stellar-background-ratio="0.5" id="home">

    <!-- COLOR OVER IMAGE -->
    <div class="color-overlay">
        <!-- To make header full screen. Use .full-screen class with color overlay. Example: <div class="color-overlay full-screen">  -->

        <!-- STICKY NAVIGATION -->
        <div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
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

                    <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt=""></a>

                </div>

                <!-- NAVIGATION LINKS -->
                <div class="navbar-collapse collapse" id="kane-navigation">
                    <ul class="nav navbar-nav navbar-right main-navigation">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="/login">Sign in</a></li>
                        <li><a href="/register">Create Account</a></li>
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
                        <img src="{{ asset('images/logo.png') }}" alt="">
                         <br> <br> <br> <br>
                        <h1 style="color: white;"><b>Earnkrypt</b></h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <!-- HEADING AND BUTTONS -->
                    <div class="intro-section">

                        <!-- WELCOM MESSAGE -->
                        <h1 class="intro">Get real time organic views for all your social media engagements</h1>
                        <h5>Applicable to </h5>

                        <!-- BUTTON -->
                        <div class="buttons" id="download-button">

                            <a href="#download" class="btn btn-default btn-lg standard-button"><i
                                    class="icon-app-download"></i>Get Started</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</header>