@extends('backend.layouts.admin')
@section('title', 'All Tasks')
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
                            <h5 class="card-title"><a href="{{ route('tasks.create') }}"><button
                                        type="button" class="btn btn-outline-primary">Add New Task</button></a></h5>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date Added</th>
                                    <th>Title</th>
                                    <th>No of Engagement</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td>{{ $task->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->users->count() }}</td>
                                       
                                        <td>{{ $task->posturl }}</td>
                                        </td>
                                        <td>{{ $task->status }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a data-toggle="tooltip" data-placement="top" title="Edit Task"
                                                    class="btn btn-info edit"
                                                    href="{{ route('tasks.edit', $task->id) }}"><i
                                                        class="fa fa-edit"></i>
                                                </a>
                                                                                              
                                                <form
                                                    action="{{ route('tasks.destroy', $task->id) }}"
                                                    method="POST" onsubmit="return confirm('You are about to permanently delete this task');">
                                                    @csrf
                                                    {{ method_field('DELETE') }}

                                                    <button type="submit" class="btn btn-danger edit"
                                                        data-toggle="tooltip" data-placement="top" title="Delete task">
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
