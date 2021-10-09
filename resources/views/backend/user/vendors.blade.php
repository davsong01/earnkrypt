@extends('backend.layouts.admin')
@section('title', 'Vendors')
@section('styles')
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
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <div class="card-header">
                        <div clas="card-body">
                            <p>Here are our most trusted vendors, these vendors have passed our verification test and you can make payment through them<br>
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
                                {{-- <p class="description">
                                    5000 &nbsp<i class="fa fa-thumbs-up like" aria-hidden="true"></i> &nbsp &nbsp &nbsp 6000 &nbsp<i class="fa fa-thumbs-down dislike" aria-hidden="true"></i>

                                </p> --}}
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
