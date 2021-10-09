@extends('backend.layouts.admin')
@section('title', 'Update Medal')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('medal.update', $medal->id) }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" required
                                            value="{{ old('title') ?? $medal->title}}">
                                    </div>
                                    <div class="form-group-inner">
                                        <label>Value ($)</label>
                                        <input type="number" class="form-control" name="value" required
                                            value="{{ old('value') ?? $medal->value }}">
                                    </div>
                                    <div class="form-group-inner">
                                        <label>Short description</label>
                                        <input type="text" class="form-control" name="description" rows="12" required
                                            value="{{ old('description') ?? $medal->description }}">
                                    </div>
                                    <div class="form-group-inner">
                                        <label>Change Icon (Optional)</label>
                                        <input type="file" class="form-control" name="icon" 
                                            value="{{ old('icon') ?? $medal->icon }}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                <div class="login-btn-inner">
                                        <div>
                                            <button style="width: 100%;"
                                                class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                                type="submit">Save Plan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

@endsection
