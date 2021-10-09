@extends('backend.layouts.admin')
@section('title', 'My Adverts')
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
                            <p>You can send us your own links for us to help you promote. <br>
                                Please note that only valid urls are allowed <br>
                                <strong>Once adverts have been approved by an admin, you can no longer edit them </strong><br>
                                Cost to promote an advert link is: <strong>${{ \App\Models\Setting::first()->value('advert_price') }}</strong>

                            </p>
                            <h5 class="card-title"><a href="{{ route('advert.create') }}"><button type="button" class="btn btn-outline-primary create">Create Advert</button></a></h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Advert Number</th>
                                    <th>Request Date</th>
                                    <th>Link</th>
                                    <th>Amount Paid</th>
                                    <th>Transaction Id</th>
                                    <th>Status</th>
                                    <th>Share count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($adverts as $advert)
                                    <tr>
                                        <td>{{ $advert->advert_number }}</td>
                                        <td>{{ $advert->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $advert->link }}</td>
                                        <td>${{ $advert->amount_paid }}</td>
                                        <td>{{ $advert->transaction_id }}</td>
                                        <td>{{ $advert->status == 0 ? 'Pending' :'Approved' }}</td>
                                        <td>{{ isset($advert->task->users)  ? $advert->task->users->count() : 0 }}</td>
                                        <td> 
                                            @if($advert->status == 0)
                                            <a data-toggle="tooltip" class="btn btn-primary edit" href="{{ route('advert.edit', $advert->id) }}"><i class="fa fa-edit"></i>
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
