@extends('backend.layouts.admin')
@section('title', 'New task')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('withdrawal.store') }}" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" required
                                            value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Link(URL)</label>
                                        <input type="url" class="form-control" name="posturl" required
                                            value="{{ old('posturl') }}">

                                    </div>
                                </div>

                                <div class="basic-login-inner">
                                    
                                    <div class="basic-login-inner">
                                        <div class="form-group-inner form-group">
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
                                </div><br>
                                <div class="login-btn-inner">
                                    <div>
                                        <button style="width: 100%;"
                                            class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                            type="submit">Save Task</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#profile-img").change(function () {
        readURL(this);
    });

</script>
@endsection
