@extends('backend.layouts.admin')
@section('title', 'Billing')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                            <a class="nav-link nav-link-extra" href="{{ route('profile.edit', auth()->user()->id) }}">GENERAL</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profile.billing') }}">BILLING</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link nav-link-extra" href="{{ route('profile.security') }}">SECURITY</a>
                            </li>
                        </ul>
                        @include('layouts.alerts')
                        
                    </div>
                    <div class="row">
                        <div class="card card-hover">
                            <div class="box bg-white text-center" style="border-radius: 10px; padding: 10px; border: #cac0c0 solid 1px;">
                                <div class="col-md-12 col-lg-12 col-xlg-12">
                                <h4 class="text">MEMBERSHIP STATUS</h4>
                                @if(auth()->user()->plan_expiry < date('Y-m-d:h:m:i'))
                                <h5 style="color:red">EXPIRED</h5>
                                <p><a href="{{ route('renew.plan') }}"><button class="btn btn-warning">RENEW</button></a>
                                </p>
                                @else
                                <h5 style="color:green">ACTIVE</h5>
                                <p>Plan expires: {{ $user->plan_expiry->format('l jS \\of F Y h:i:s A') }}</p>
                                @endif
                            </div>
 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

