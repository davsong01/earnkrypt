@extends('backend.layouts.admin')
@section('title', 'Update Notification')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-title">
                @include('layouts.alerts')
        </div>
        <form action="{{ route('notification.update', $notification->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group-inner">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" required
                            value="{{ old('notification') ?? $notification->title}}">
                    </div>
                </div>   
                <div class="col-md-12">
                    <div class="form-group-inner">
                        <label>Content</label>
                        <label for="content">Content</label>
                        <textarea required="required" id="content" type="text" class="form-control" name="content" value="{{ old('content') }}" rows="8" autofocus>{{ old('content') ?? $notification->content}}</textarea>
                    </div>
                </div>  
                <div class="col-md-12">
                    <div class="form-group-inner">
                        <label>Status</label>
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="" required>
                            <option value="">--Select--</option>
                            <option value="1" {{ $notification->status == '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $notification->status == '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                       
                    </div>
                </div>           
            </div>
           
            <div class="row">
                <div class="col-12">
                <div class="login-btn-inner">
                    <div>
                        <button style="width: 100%; margin-top:10px" class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                            type="submit">Update notification</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>   
<script>
    CKEDITOR.replace( 'content');
</script>
@endsection

