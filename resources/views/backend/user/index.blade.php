@extends('backend.layouts.admin')
@section('title', 'Promote')
@section('content')
<div class="container-fluid">
    @include('layouts.alerts')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Hello {{ auth()->user()->name }}</h5>
                    <p>Please select a medium to promote today's task on <br><br></p>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xlg-6" style="max-width: 45%;">
                            <a href="{{ route( 'promote.new', 1 ) }}" target="_blank">
                            <div class="card card-hover">
                                <img src="{{ asset('images/site/facebook.png') }}" alt="" style="width:30%; margin: auto;">
                            </div>
                            </a>
                        </div>
                        <br>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xlg-6" style="max-width: 42%;">
                            <a href="{{ route( 'promote.new', 2 ) }}">
                            <div class="card card-hover">
                                <img src="{{ asset('images/site/whatsapp.png') }}" alt="" style="width:35%; margin: auto;">
                            </div>
                            </a>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection