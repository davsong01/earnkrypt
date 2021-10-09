@extends('backend.layouts.admin')
@section('title', 'Update Design')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p>
                        <strong>User: </strong>{{ $design->design_number }} <br>
                        <strong>User: </strong>{{ $design->user->username }} <br>
                        <strong>Amount Paid: </strong>${{ $design->amount_paid }} <br>
                        <strong>Status: </strong>@if($design->status == 0)
                        Pending
                        @endif
                        @if($design->status == 1)
                        Processing
                        @endif
                        @if($design->status == 2)
                        Complete
                        @endif <br>
                    </p>
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    @if(auth()->user()->user_types != 1 )
                        <form action="{{ route('design.approve', $design->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <fieldset class="form-group">
                                    <label for="type">Change design status</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="0" {{ $design->status == 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ $design->status == 1 ? 'selected' : '' }}>Processing</option>
                                        <option value="2" {{ $design->status == 2 ? 'selected' : '' }}>Complete</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="file" style="display:none">
                                @if($design->type == 'logo' || $design->type == 'flier')
                                <fieldset class="form-group">
                                    <label for="type">Upload complete design file</label>
                                    <input class="form-control" type="file" name="file" id="file" value="{{ old('file') }}">
                                </fieldset>
                                @else
                                <fieldset class="form-group">
                                    <label for="type">Enter url to download graphics video</label>
                                    <input class="form-control" type="url" name="url" id="url" value="{{ old('url') }}">
                                </fieldset>
                                @endif
                            </div>
                           
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for=""></label>
                                <input type="submit" value="Update Status" style="width: 100%; margin-top: 10px; padding: 10px;"
                                        class="btn btn-lg btn-info">
                            </div>
                        </form>
                        </div>
                        @endif
                    <form action="{{ route('design.update', $design->id) }}" onsubmit="return confirm('Are you sure, this action is irreversible once your design is approved')" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Type</label>
                                        <input type="text" class="form-control" value="{{ $design->type }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Description(Tell us about this design, you can include specific instructions)</label>
                                        <textarea name="description" id="description" style="width: 100%;" cols="30" rows="10" value="{{ old('description') ?? $design->description }}">{{ old('description') ??$design->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="login-btn-inner">
                                    <div>
                                        @if(auth()->user()->user_types == 1 && $design->status == 0 )
                                        <button style="width: 100%;"
                                            class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                            type="submit">Send design order</button>
                                        @endif
                                        @if(auth()->user()->user_types != 1)
                                        <button style="width: 100%;"
                                        class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                        type="submit">Update design</button> <br><br>
                                        
                                        @endif
                                        
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
<script>
     $('#status').on('change', function(){
        if($('#status').val()=='2'){
            $('#file').show();
        }else{
            $('#file').hide();
        };

        
    });
</script>
@endsection
