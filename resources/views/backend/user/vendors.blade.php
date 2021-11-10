@extends('backend.layouts.admin')
@section('title', 'Vendors')
@section('styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
    .serviceBox{
    font-family: 'Poppins', sans-serif;
    text-align: center;
    padding: 0 10px;
}
.serviceBox .service-icon{
    color: #fe8c00;
    background: linear-gradient(to bottom,#fe8c00,transparent);
    font-size: 80px;
    line-height: 170px;
    width: 170px;
    height: 170px;
    margin: 0 auto 10px;
    border-radius: 50% 50% 0 0;
    position: relative;
    z-index: 1;
}
.serviceBox .service-icon:before{
    content: "";
    background: #fff;
    width: 85%;
    height: 85%;
    border-radius: 50%;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
    transform: translateX(-50%) translateY(-50%);
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: -1;
}
.serviceBox .title{
    color: #444;
    font-size: 20px;
    font-weight: 600;
    line-height: 25px;
    text-transform: uppercase;
    margin: 0 0 5px;
}
.serviceBox .description{
    color: #555;
    font-size: 13px;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 0;
}
.serviceBox.pink .service-icon{
    color: #fd78b0;
    background: linear-gradient(to bottom,#fd78b0,transparent);
}
.serviceBox.purple .service-icon{
    color: #bd85e4;
    background: linear-gradient(to bottom,#bd85e4,transparent);
}
.serviceBox.green .service-icon{
    color: #7fcc4b;
    background: linear-gradient(to bottom,#7fcc4b,transparent);
}
@media only screen and (max-width: 990px){
    .serviceBox{ margin: 0 0 30px; }
}
.like{
    font-size: 20px;
    color: #FFBA00;
    float: inherit;
    display: inline-block;
    margin-bottom: 10px;
}

.dislike{
    font-size: 20px;
    color: black;
    float: inherit;
    display: inline-block;
    margin-bottom: 10px;
}

.modal-header .close {
    background: red;
    padding: 10px;
    border-radius: 50%;
    color: white;
    opacity: unset;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div>
            <div class="serviceBox">
                <div class="service-icon">
                    <span><i class="fa fa-address-card"></i></span>
                </div>
                <div class="service-content">
                    <h3 class="title">become a vendor</h3>
                    <a target="_blank" href="mailto:{{ \App\Models\Setting::first()->value('official_mail') }}?subject=Vendor Application&body=I would like to apply for a vendor on {{ config('app.name') }}! Below are my details" style="border-radius: 10%;" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit">APPLY</a>
                    
                    <a data-target="#myModal" data-toggle="modal" href="#myModal" style="border-radius: 10%;" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit">ELIGIBILITY</a>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
        
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
                </div>
                <div class="modal-body">
                <h4 class="modal-title">Requirements for vendor eligibility</h4><br>
                    <p>
                       For security and safety of our users, we require you to meet the following requirements to be eligible for the position of a verified Crypto Vendor. <br><br>
                       
                       - Your Full Name as shown on your National ID card.<br><br>
                        - A portrait picture of you with your face very clear.<br><br>
                        - A selfie picture and a short video of you holding your National ID card<br><br>
                        - The Bank Details you intend to use for vending transactions on the website and the BVN Attached to it.<br><br>
                        - Your account statement of the last 30 days (PDF).<br><br>
                        - Please try and provide all the above mentioned requirements, it's only to protect every user and make transactions as safe as possible.
                    </p>
                   
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        
            </div>
        </div>
        <div class="col-md-12">
            <div class="card" style="margin-top: 20px;">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <div class="card-header">
                        <div clas="card-body">
                            <p>
                                Please select one of our trusted vendors below, these vendors have passed our verification test and you can make payment through them<br>
                            </p>
                        </div>
                    </div>
                   
                    <div class="row">
                        @foreach($vendors as $vendor)
                        <div class="col-md-4 col-sm-12">
                            <div class="serviceBox">
                                <div class="service-icon">
                                    <span><i class="fa fa-certificate"></i></span>
                                </div>
                                <h6 class="title">{{ $vendor->name }}</h6>
                            
                                <a target="_blank" href="https://wa.me/{{ $vendor->phone }}?text=I want to buy Crypto to pay on {{ config('app.name') }}" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit">Contact</a>
                                <a href="" onclick="alert('Please send a mail to {{ \App\Models\Setting::first()->value('official_mail') }} to report this vendor')" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit">Report</a>
                            </div>
                        </div>
                        @endforeach
                       
                    </div>
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
