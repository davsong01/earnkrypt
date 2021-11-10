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
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td>{{ $transaction->user->username ?? 'N/A' }}</td>
                                        <td>{{ $transaction->reference}}</td>
                                        <td>{{ $transaction->amount}}</td>
                                        <td>{{ $transaction->status}} </td>
                                        <td> <small>
                                            @if($transaction->type == 1) New Plan @endif
                                            @if($transaction->type == 2) Plan Renewal @endif
                                            @if($transaction->type == 3) Advert @endif
                                            @if($transaction->type == 4) Design @endif
                                            
                                            </small>
                                        </td>
                                        <td>{{ $transaction->status == 'PENDING' ? '' : date(json_decode($transaction->payment_data, true)['confirmed_at'])}}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if($transaction->status != 'CONFIRMED')
                                                <a data-toggle="tooltip" data-placement="top" title="Edit medal"
                                                    class="btn btn-info edit"
                                                    href="{{ route('transaction.edit', $transaction->id) }}"><i
                                                        class="fa fa-edit"></i>
                                                </a>
                                                @endif
                                                <form
                                                    action="{{ route('transaction.destroy', $transaction->id) }}"
                                                    method="POST" onsubmit="return confirm('You are about to permanently delete this transaction');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger edit"
                                                        data-toggle="tooltip" data-placement="top" title="Delete transaction">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
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
