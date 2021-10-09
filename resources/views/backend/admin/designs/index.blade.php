@extends('backend.layouts.admin')
@section('title', 'All design orders')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Design Number</th>
                                    <th>Request Date</th>
                                    <th>Username</th>
                                    <th>Amount Paid</th>
                                    <th>Transaction Id</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($designs as $design)
                                    <tr>
                                        <td>{{ $design->design_number }}</td>
                                        <td>{{ $design->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $design->user->username ?: '' }}</td>
                                        <td>${{ $design->amount_paid }}</td>
                                        <td>{{ $design->transaction_id }}</td>
                                        <td>
                                            @if($design->status == 0)
                                            Pending
                                            @endif
                                            @if($design->status == 1)
                                            Processing
                                            @endif
                                            @if($design->status == 2)
                                            Complete <br>
                                                @if($design->type == 'logo' || $design->type == 'flier')
                                                <a href="/uploads/designs/{{ $design->file }}"><strong>Download design</strong></a>
                                                @endif
                                                @if($design->type == 'graphics_video')
                                                <a target="_blank" href="{{ $design->file }}"><strong>Download Link</strong></a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-info edit" href="{{ route('design.edit', $design->id) }}"><i data-toggle="tooltip" data-placement="top" title="Edit/Approve design" class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
