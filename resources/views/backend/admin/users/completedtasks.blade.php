@extends('backend.layouts.admin')
@section('title', 'All Completed Tasks')
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
                                    <th>Date shared</th>
                                    <th>Name</th>
                                    <th>Plan</th>
                                    <th>Task</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($completedTasks as $task)
                                    <tr>
                                        <td>{{ $count ++ }}</td>
                                        <td>{{ $task->created_at }}</td>
                                        <td>{{ $task->user->name }}<br>
                                       <span>{{ $task->user->email }}</span>
                                        </td>
                                        <td>{{ $task->user->plans->title }} <br> <small style="color:green">Daily return : ${{ $task->user->plans->daily_returns }}</small>
                                        <td>{{ $task->task->posturl }}</td>
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
