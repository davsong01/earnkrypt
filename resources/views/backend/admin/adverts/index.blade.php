@extends('backend.layouts.admin')
@section('title', 'All advert placements')
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
                                    <th>Advert Number</th>
                                    <th>Request Date</th>
                                    <th>Username</th>
                                    <th>Link</th>
                                    <th>Amount Paid</th>
                                    <th>Transaction Id</th>
                                    <th>Engagement</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($adverts as $advert)
                                    <tr>
                                        <td>{{ $advert->advert_number }}</td>
                                        <td>{{ $advert->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $advert->user->username ?: '' }}</td>
                                        <td>{{ $advert->link }}</td>
                                        <td>${{ $advert->amount_paid }}</td>
                                        <td>{{ $advert->transaction_id }}</td>
                                        <td>{{ isset($advert->task->users)  ? $advert->task->users->count() : 0 }}</td>
                                        <td>{{ $advert->status == 0 ? 'Pending' : 'Aprroved' }}</td>
                                      
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-info edit" href="{{ route('advert.edit', $advert->id) }}"><i data-toggle="tooltip" data-placement="top" title="Edit/Approve advert" class="fa fa-edit"></i>
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
