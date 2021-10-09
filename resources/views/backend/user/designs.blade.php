@extends('backend.layouts.admin')
@section('title', 'My Designs')
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
                            <p>You can order for designs here<br>
                                Please note that only valid urls are allowed <br>
                                <strong>Once designs have been processed by an admin, you can no longer edit it </strong>
                            </p>
                            <h5 class="card-title"><a href="{{ route('design.create') }}"><button type="button" class="btn btn-outline-primary create">Order for a design</button></a></h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Order date</th>
                                    <th>Design Number</th>
                                    <th>Amount Paid</th>
                                    <th>Description</th>
                                    <th>Transaction Id</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($designs as $design)
                                    <tr>
                                        
                                        <td>{{ $design->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $design->design_number }}</td>
                                        <td>${{ $design->amount_paid }}</td>
                                        <td>{{ $design->description }}</td>
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
                                            @if($design->status == 0)
                                            <a data-toggle="tooltip" class="btn btn-primary edit" href="{{ route('design.edit', $design->id) }}"><i class="fa fa-edit"></i>
                                            </a>
                                            @endif
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
