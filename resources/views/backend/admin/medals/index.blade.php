@extends('backend.layouts.admin')
@section('title', 'All medals')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    {{-- <div class="card-header">
                        <div>
                            <h5 class="card-title"><a href="{{ route('medal.create') }}"><button type="button" class="btn btn-outline-primary">Add New medal</button></a></h5>
                        </div>
                    </div> --}}

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Value</th>
                                    <th>Awardees</th>
                                    <th>Manage</th>
                                    <th>Date Added</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($medals as $medal)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td><img src="{{'/uploads/' .$medal->icon }}" id="profile-img-tag" width="40px"> </td>
                                        <td>{{ $medal->title }}</td>
                                        <td>${{ $medal->value }}</td>
                                        <td>{{ $medal->users_count }}</td>
                                        <td>{{ $medal->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a data-toggle="tooltip" data-placement="top" title="Edit medal"
                                                    class="btn btn-info edit"
                                                    href="{{ route('medal.edit', $medal->id) }}"><i
                                                        class="fa fa-edit"></i>
                                                </a>
                                                                                              
                                                <form
                                                    action="{{ route('medal.destroy', $medal->id) }}"
                                                    method="POST" onsubmit="return confirm('You are about to permanently delete this medal');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger edit"
                                                        data-toggle="tooltip" data-placement="top" title="Delete medal">
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
