@extends('backend.layouts.admin')
@section('title', 'Medals')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                 <div class="card-title">
                    @include('layouts.alerts')
                    <div class="card-header">
                     Earn medals for fun, bragging rights, and to showcase your awesomeness. <br>
                     <span style="color:#FFBA00">Resets at the end of your Subscription plan</span>
                </div>
                </div>
                
                <div class="card-body">
                    <div class="container" style="max-width: 800px;">
                        <center>
                            <ul class="list-group">
                            @foreach($medals as $medal)
                            <li class="list-group-item" style="padding: 20px; font-size: 12px;">
                                <div class="row">
                                    <div class="col-md-1 col-sm-1">
                                        <img src="{{'/uploads/' .$medal->icon }}" id="profile-img-tag" width="40px" style="margin: auto;
                                    width: 50%;border-radius: 50%; width:50px;height:50px;" alt="medal_icon">
                                    </div>
                                    <div class="col-md-10 col-sm-10">
                                        
                                    <strong> {{ $medal->title }}</strong> <br>
                                    <p>+${{ $medal->value }} | {{ $medal->description }}</p>
                                        
                                    </p>
                                    </div>
                                    <div class="col-md-1 col-sm-1">
                                        @if(isset($medal->awarded) && $medal->awarded == 'yes' )
                                            <i class="fa fa-certificate" style="color:#27a9e3; font-size: 18px;"></i>
                                        @else
                                            <i class="fa fa-certificate" style="color:ash; font-size: 18px;"></i>
                                        @endif
                                    
                                    </div>
                                    
                                </div>
                                {{-- <div class="details">
                                    <p style="width:500px"><img src="{{'/uploads/' .$medal->icon }}" id="profile-img-tag" width="40px" style="border-radius: 50%; width:50px;height:50px;margin-right:15px; float: left;" alt="medal_icon">
                                        {{ $medal->title }} <br>
                                        <span>{{ $medal->description }}</span>
                                        
                                    </p>
                                    
                                    
                                </div> --}}
                                {{-- <div class="medal">
                                    <span><i class="fa fa-certificate"></i></span>
                                </div> --}}
                            
                            </li>
                            @endforeach
                            </ul>
                        </center>
                </div>    

            </div>
        </div>
    </div>
</div>
</div>
@endsection
