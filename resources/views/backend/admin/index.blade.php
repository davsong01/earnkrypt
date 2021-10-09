@extends('backend.layouts.admin')

@section('content')
@section('title'){{ $title }}@endsection
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Site Analysis</h4>
                                </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('user.index') }}">
                                            <div class="bg-dark p-10 text-white text-center">
                                            <i class="fa fa-user m-b-5 font-16"></i>
                                            <h5 class="m-b-0 m-t-5">{{ $subscribers }}</h5>
                                            <small class="font-light">Total Subscribers</small>
                                            </div>
                                        </a>
                                    </div>
                                    
                                     <div class="col-6">
                                        <a href="{{ route('plans.index') }}">
                                            <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-chart-bar m-b-5 font-16"></i>
                                            <h5 class="m-b-0 m-t-5">{{ $plans }}</h5>
                                            <small class="font-light">Number of plans</small>
                                            </div>
                                        </a>
                                    </div>
                                   
                                    <div class="col-6 m-t-15">
                                        <a href="{{ route('withdraw.index') }}">
                                            <div class="bg-dark p-10 text-white text-center">
                                            <i class="fa fa-cart-plus m-b-5 font-16"></i>
                                            <h5 class="m-b-0 m-t-5">{{ $withdraw_request }}</h5>
                                            <small class="font-light">Withdraw Requests</small>
                                            </div>
                                        </a>
                                    </div>
                                     <div class="col-6 m-t-15">
                                        <a href="{{ route('withdraw.index') }}">
                                            <div class="bg-dark p-10 text-white text-center">
                                            <i class="mdi mdi-wallet-travel m-b-5 font-16"></i>
                                            <h5 class="m-b-0 m-t-5">{{ $pending_requests }}</h5>
                                            <small class="font-light">Pending Withdrawals</small>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 m-t-15">
                                        <a href="{{ route('tasks.index') }}">
                                            <div class="bg-dark p-10 text-white text-center">
                                            <i class="fa fa-list m-b-5 font-16"></i>
                                            <h5 class="m-b-0 m-t-5">{{ $tasks }}</h5>
                                            <small class="font-light">All Tasks</small>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 m-t-15">
                                        <a href="{{ route('medal.index') }}">
                                            <div class="bg-dark p-10 text-white text-center">
                                            <i class="fa fa-certificate m-b-5 font-16"></i>
                                            <h5 class="m-b-0 m-t-5">{{ $medals }}</h5>
                                            <small class="font-light">All Medals</small>
                                            </div>
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- column -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-0">Progress Box</h4>
                        <div class="m-t-20">
                            <div class="d-flex no-block align-items-center">
                                <span>81% Clicks</span>
                                <div class="ml-auto">
                                    <span>125</span>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 81%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex no-block align-items-center m-t-25">
                                <span>72% Uniquie Clicks</span>
                                <div class="ml-auto">
                                    <span>120</span>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 72%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex no-block align-items-center m-t-25">
                                <span>53% Impressions</span>
                                <div class="ml-auto">
                                    <span>785</span>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 53%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex no-block align-items-center m-t-25">
                                <span>3% Online Users</span>
                                <div class="ml-auto">
                                    <span>8</span>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 3%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}
       
    </div>
@endsection