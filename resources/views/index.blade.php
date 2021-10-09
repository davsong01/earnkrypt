@extends('welcome')
@section('body')
    <section class="features" id="features">

        <div class="container">

            <!-- SECTION HEADER -->
            <div class="section-header wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">

                <!-- SECTION TITLE -->
                <h2 class="dark-text">Why Earnkrypt?</h2>
                <div class="colored-line">
                </div>
                <div class="section-description">
                Getting to grow your social media engagements can be very annoying, We know, That's why we built Earnkrypt. With Earnkrypt you cna easily buy real time social media engagements in no time.
                </div>
                <div class="colored-line">
                </div>
            </div>
            <!-- /END SECTION HEADER -->

            <div class="row">

                <!-- FEATURES LEFT -->
                <div class="col-md-4 col-sm-4 features-left wow fadeInLeft animated" data-wow-offset="10"
                    data-wow-duration="1.5s">

                    <!-- FEATURE -->
                    <div class="feature">

                        <!-- ICON -->
                        <div class="icon-container">
                            
                                <img src="{{ asset('assets/features-icons/ecology.svg') }}" style="width: 50px;" alt="">
                            
                        </div>

                        <!-- FEATURE HEADING AND DESCRIPTION -->
                        <div class="fetaure-details">
                            <h4 class="main-color">Human Views</h4>
                            <p>Earnkrypt global provide an avenue for publishers to pay to promote their Business. so you're absolutely certain to be paid once you're done. Revenues readily available for dispensal. </p>
                        </div>

                    </div>
                    <!-- /END SINGLE FEATURE -->

                    <!-- FEATURE -->
                    <div class="feature">

                        <!-- ICON -->
                        <div class="icon-container">
                            
                                <img src="{{ asset('assets/features-icons/robot.svg') }}" style="width: 50px;" alt="">
                            
                        </div>

                        <!-- FEATURE HEADING AND DESCRIPTION -->
                        <div class="fetaure-details">
                            <h4 class="main-color">No Annoying Bots</h4>
                            <p>No pesky bots. No ban risk on your social media accounts. </p>
                        </div>

                    </div>
                    <!-- /END SINGLE FEATURE -->

                    <!-- FEATURE -->
                    <div class="feature">

                        <!-- ICON -->
                        <div class="icon-container">
                            
                                <img src="{{ asset('assets/features-icons/star-number-five.svg') }}" style="width: 50px;" alt="">
                            
                        </div>

                        <!-- FEATURE HEADING AND DESCRIPTION -->
                        <div class="fetaure-details">
                            <h4 class="main-color">5-Star Service</h4>
                            <p>All hands on desk to ensure smooth running of the programme. Customer care service also active. Hit us up whenever you have a complaint, we will get back to you ASAP!</p>
                        </div>

                    </div>
                    <!-- /END SINGLE FEATURE -->

                </div>
                <!-- /END FEATURES LEFT -->

                <!-- PHONE IMAGE -->
                <div class="col-md-4 col-sm-4">
                    <div class="phone-image wow bounceIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                        <img src="{{ asset('images/why.jpg') }}" alt="">
                    </div>
                </div>

                <!-- FEATURES RIGHT -->
                <div class="col-md-4 col-sm-4 features-right wow fadeInRight animated" data-wow-offset="10"
                    data-wow-duration="1.5s">

                    <!-- FEATURE -->
                    <div class="feature">

                        <!-- ICON -->
                        <div class="icon-container">
                            
                                <img src="{{ asset('assets/features-icons/wow.svg') }}" style="width: 50px;" alt="">
                            
                        </div>

                        <!-- FEATURE HEADING AND DESCRIPTION -->
                        <div class="fetaure-details">
                            <h4 class="main-color">Easy Setup</h4>
                            <p>Get started in with no stress. Hit the create account button and sign up in no time. You are few steps away</p>
                        </div>

                    </div>
                    <!-- /END SINGLE FEATURE -->

                    <!-- FEATURE -->
                    <div class="feature">

                        <!-- ICON -->
                        <div class="icon-container">
                            
                                <img src="{{ asset('assets/features-icons/marketing.svg') }}" style="width: 50px;" alt="">
                            
                        </div>

                        <!-- FEATURE HEADING AND DESCRIPTION -->
                        <div class="fetaure-details">
                            <h4 class="main-color">Entising referral bonus</h4>
                            <p>Huge affiliate commision on users you personally refer with your profile link. Advertise your link to get some juicy bonuses. Work smart </p>
                        </div>

                    </div>

                    <!-- /END SINGLE FEATURE -->

                    <!-- FEATURE -->
                    <div class="feature">

                        <!-- ICON -->
                        <div class="icon-container">
                            
                                <img src="{{ asset('assets/features-icons/security.svg') }}" style="width: 50px;" alt="">
                            
                        </div>

                        <!-- FEATURE HEADING AND DESCRIPTION -->
                        <div class="fetaure-details">
                            <h4 class="main-color">Safe and Secure</h4>
                            <p>We provide real human views. Funds are safe and secured. Withdraw your earnings whenever you are due. You do the work, you get paid. Period.</p>
                        </div>

                    </div>
                    <!-- /END SINGLE FEATURE -->

                </div>
                <!-- /END FEATURES RIGHT -->

            </div>
            <!-- /END ROW -->

        </div>
        <!-- /END CONTAINER -->

    </section>
    <!-- /END FEATURES SECTION -->

   

    <!-- =========================
    TESTIMONIALS 
    ============================== -->
    
    <!-- /END TESTIMONIALS SECTION -->


    

    <!-- =========================
    PRICING TABLE | Added on version 1.7   
    ============================== -->
    <section class="packages" id="pricing">

        <div class="container">

            <!-- SECTION HEADER -->
            <div class="section-header wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

                <!-- SECTION TITLE -->
                <h2 class="dark-text">Affordable Packages</h2>
                <div class="colored-line">
                </div>

                <div class="section-description">
                    List your app features and all the details Lorem ipsum dolor kadr
                </div>

                <div class="colored-line">
                </div>
            </div>
            <!-- /END SECTION HEADER -->

            <div class="row">
                @foreach($plans as $plan)
                <div class="col-md-4 col-sm-4 single-service wow fadeIn animated" data-wow-offset="10"
                    data-wow-duration="1.5s">

                    <div class="single-package">

                        <h3 class="package-heading main-color">{{ $plan->title }} </h3>

                        <div class="price">
                            <h3><span class="sign">$</span>{{ $plan->amount }} <span class="month">/{{ $plan->validity }} days</span></h3>
                        </div>

                        <ul class="package-feature">
                            {!! $plan->description !!}
                            
                        </ul>

                    </div>
                </div>
                @endforeach
            
            </div>
            <!-- /END ROW -->

        </div>
        <!-- /END CONTAINER -->
    </section>
    <!-- /END PRICING TABLE SECTION -->
@endsection