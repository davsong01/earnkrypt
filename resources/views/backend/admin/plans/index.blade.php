@extends('backend.layouts.admin')
@section('title', 'All Plans')
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
                            @if(auth()->user()->user_types == 3)
                            <h5 class="card-title"><a href="{{ route('plans.create') }}"><button type="button" class="btn btn-outline-primary" style="font-size: 18px;">Add New Plan</button></a></h5>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date Added</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Commission</th>
                                    <th>No of Subscribers</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td>{{ $plan->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $plan->title }}</td>
                                        <td>${{ $plan->amount }}</td>
                                        <td>{{ $plan->commission }}%</td>
                                        <td>{{ $plan->users->count() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a data-toggle="tooltip" data-placement="top" title="Edit plan"
                                                    class="btn btn-info edit"
                                                    href="{{ route('plans.edit', $plan->id) }}"><i
                                                        class="fa fa-edit"></i>
                                                </a>
                                                                                              
                                                <form
                                                    action="{{ route('plans.destroy', $plan->id) }}"
                                                    method="POST" onsubmit="return confirm('You are about to permanently delete this plan');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger edit"
                                                        data-toggle="tooltip" data-placement="top" title="Delete plan">
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
