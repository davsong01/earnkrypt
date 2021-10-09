@extends('backend.layouts.admin')
@section('title', 'All transactions')
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
                                    <th>Subscriber</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td>{{ $transaction->user->username ?? 'N/A' }}</td>
                                        <td>{{ $transaction->reference}}</td>
                                        <td>{{ $transaction->amount}}</td>
                                        <td>{{ $transaction->type}}</td>
                                        <td>{{ date(json_decode($transaction->payment_data, true)['confirmed_at'])}}</td>
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
