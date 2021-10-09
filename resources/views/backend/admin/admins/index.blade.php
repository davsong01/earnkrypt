@extends('backend.layouts.admin')
@section('title', 'All admins')
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
                            <h5 class="card-title"><a href="{{ route('admins.create') }}"><button type="button" class="btn btn-outline-primary">Add New admin</button></a></h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td><img class="mr-1" style="border-radius:50%" src="{{ asset($admin->avatar ? 'uploads/'.$admin->avatar : 'uploads/avatars/default.jpg') }}" alt="avatar" height="40" width="40"></td>
                                        </td>
                                        <td>{{ $admin->name }}<br><span><a href="{{ config('app.url').'/register?ref='.$admin->adminname }}">{{ config('app.url').'/register?ref='.$admin->adminname }}</a> </span></td>
                                        
                                        <td>{{ $admin->email }}</td>
                                       
                                        <td>
                                            <div class="btn-group">
                                                <a data-toggle="tooltip" data-placement="top" title="Edit admin"
                                                    class="btn btn-info"
                                                    href="{{ route('admins.edit', $admin->id) }}"><i
                                                        class="fa fa-edit"></i>
                                                </a>
                                                                                              
                                                <form
                                                    action="{{ route('admins.destroy', $admin->id) }}"
                                                    method="POST" onsubmit="return confirm('You are about to permanently delete this admin');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-xsm"
                                                        data-toggle="tooltip" data-placement="top" title="Delete admin">
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
