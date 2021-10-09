@extends('backend.layouts.admin')
@section('title', 'All Users')
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
                            <h5 class="card-title"><a href="{{ route('user.create') }}"><button type="button" class="btn btn-outline-primary edit">Add New user</button></a></h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Referral</th>
                                    <th>Plan</th>
                                    <th>Analytics</th>
                                   
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        {{-- <td>{{ $count ++ }}</td> --}}
                                        <td><img class="mr-1" style="border-radius:50%" src="{{ asset($user->avatar ? 'uploads/'.$user->avatar : 'uploads/avatars/default.jpg') }}" alt="avatar" height="40" width="40"></td>
                                        </td>
                                        <td>{{ $user->name }}<br><span><a href="{{ config('app.url').'/register?ref='.$user->username }}">{{ config('app.url').'/register?ref='.$user->username }}</a> </span> <br>
                                        {{ $user->email }}
                                        </td>
                                        
                                        <td><small>{{ isset($user->upline->name) ? $user->upline->name : 'N/A'}} </small></td>
                                        <td><small><strong>{{ isset($user->plans->title) ? $user->plans->title : 'N/A' }} </strong>
                                            @if(isset($user->plans )) <br>
                                            <span>Start: {{ $user->plan_expiry->subMonth(1) }} </span> <br>
                                            {{-- Carbon::now()->addMonth(1) --}}
                                            <span>End: {{ $user->plan_expiry }}</span>
                                            @endif </small>
                                        </td>
                                        <td><small><strong>Wallet: </strong> ${{ number_format($user->wallet_balance + $user->referral_wallet_balance + $user->medals_wallet_balance) }} <br>
                                           <strong>Tasks:</strong> {{ $user->tasks->count() }} <br>
                                          <strong>Medals: </strong>{{ $user->medals->count() }} </small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-info edit"
                                                    href="{{ route('user.edit', $user->id) }}"><i
                                                        class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit user"></i>
                                                </a>
                                                                                             
                                                <form
                                                    action="{{ route('user.show', $user->id) }}"
                                                    method="POST" onsubmit="return confirm('You are about to permanently delete this user');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-xsm edit"
                                                        data-toggle="tooltip" data-placement="top" title="Delete user">
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
