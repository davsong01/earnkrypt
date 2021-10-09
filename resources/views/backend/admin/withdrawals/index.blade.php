@extends('backend.layouts.admin')
@section('title', 'All Withdrawals')
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
                                    <th>S/N</th>
                                    <th>Request Date</th>
                                    <th>Username</th>
                                    <th>Withdrawn from</th>
                                    <th>Requested Amount</th>
                                    <th>Status</th>
                                    <th>Payment Date</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdrawals as $withdrawal)
                                    <tr>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $count ++ }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->created_at->format('Y-m-d') }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ isset($withdrawal->user->username) ? $withdrawal->user->username : 'N/A' }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->wallet_type }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->amount}}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->paid == 0 ? 'Pending' :'Paid' }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->date_paid }}</td>
                          
                                        <td>
                                            <div class="btn-group">
                                                <a data-toggle="tooltip" data-placement="top" title="Edit withdrawal" class="btn btn-info" href="{{ route('withdraw.edit', $withdrawal->id) }}"><i class="fa fa-edit"></i>
                                                </a>
                                                <a data-toggle="tooltip" onclick="return confirm('You sure?');"  data-placement="top" title="Delete withdrawal" class="btn btn-danger" href="{{ route('withdrawal.delete', $withdrawal->id) }}"><i class="fa fa-trash"></i>
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
