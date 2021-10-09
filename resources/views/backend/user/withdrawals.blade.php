@extends('backend.layouts.admin')
@section('title', 'My Withdrawals Histrory')
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
                        <div>
                          
                           
                            <h5 class="card-title"><a href="{{ route('withdraw.create') }}"><button
                                type="button" class="btn btn-outline-primary create">Request for withdrawal</button></a></h5>
       
                            
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Request Date</th>
                                    <th>Withdrawn from</th>
                                    <th>Amount requested ($)</th>
                                    <th>Commission charged($)</th>
                                    <th>Status</th>
                                    <th>Date Paid</th>
                                    <td>Manage</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdrawals as $withdrawal)
                                    <tr>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $count ++ }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->created_at->format('Y-m-d') }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->wallet_type }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->amount }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->commission }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->paid == 0 ? 'Pending' :'Paid' }}</td>
                                        <td style="color:{{ $withdrawal->paid == 0 ? 'red' :'green' }}">{{ $withdrawal->date_paid }}</td>
                                        <td> 
                                            @if($withdrawal->paid == 0)
                                            <a data-toggle="tooltip" onclick="return confirm('I hope you really know what you are doing?');"  data-placement="top" title="Delete withdrawal" class="btn btn-danger edit" href="{{ route('withdrawal.delete', $withdrawal->id) }}"><i class="fa fa-trash"></i>
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
