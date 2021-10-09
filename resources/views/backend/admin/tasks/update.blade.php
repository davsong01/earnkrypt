@extends('backend.layouts.admin')
@section('title', 'Edit: '.$task->title)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('patch')
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" required
                                        value="{{ old('title') ?? $task->title}}">

                            </div>
                        </div>
                        <div class="basic-login-inner">
                            <div class="form-group-inner">
                                <label>Link(URL)</label>
                                <input type="url" class="form-control" name="posturl" required
                                    value="{{ old('posturl') ?? $task->posturl }}">

                            </div>
                        </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="basic-login-inner">
                                <div class="form-group-inner">
                                    <label>Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Publish"
                                            {{ old('status') == 'Publish' ? 'selected' : '' }}>
                                            Publish</option>
                                        <option value="Draft"
                                            {{ old('status') == 'Draft' ? 'selected' : '' }}>
                                            Draft</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="login-btn-inner">
                            <div>
                                <button style="width: 100%;" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                    type="submit">Update Task</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

