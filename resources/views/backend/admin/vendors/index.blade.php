@extends('backend.layouts.admin')
@section('title', 'All Vendors')
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
                            <h5 class="card-title"><a href="{{ route('vendor.create') }}"><button type="button" class="btn btn-outline-primary create" style="font-size: 18px;">Add New Vendor</button></a></h5>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date Added</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Likes</th>
                                    <th>Dislikes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendors as $vendor)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td>{{ $vendor->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $vendor->name }}</td>
                                        <td>{{ $vendor->email }}</td>
                                        <td>{{ $vendor->phone }}</td>
                                        <td>{{ $vendor->likes }}</td>
                                        <td>{{ $vendor->dislikes }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-info edit"
                                                    href="{{ route('vendor.edit', $vendor->id) }}"><i data-toggle="tooltip" data-placement="top" title="Edit vendor"
                                                        class="fa fa-edit"></i>
                                                </a>
                                                                                              
                                                <form
                                                    action="{{ route('vendor.destroy', $vendor->id) }}"
                                                    method="POST" onsubmit="return confirm('You are about to permanently delete this vendor');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-xsm edit">
                                                        <i  data-toggle="tooltip" data-placement="top" title="Delete vendor" class="fa fa-trash"></i>
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
