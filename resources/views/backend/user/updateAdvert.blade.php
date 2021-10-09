@extends('backend.layouts.admin')
@section('title', 'Update Advert')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p>
                        <strong>User:</strong>{{ $advert->user->username }} <br>
                        <strong>Amount Paid: </strong>${{ $advert->amount_paid }} <br>
                        <strong>Status </strong>{{ $advert->status == 0 ? 'Pending' : 'Approved' }} <br>
                        
                    </p>
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                    <form action="{{ route('advert.update', $advert->id) }}" onsubmit="return confirm('Are you sure, this action is irreversible once your advert is approved')" method="POST"
                        enctype="multipart/form-data" class="pb-2">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Link</label>
                                        <input type="url" class="form-control" value="{{ old('link') ?? $advert->link }}" name="link" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-inner">
                                    <div class="form-group-inner">
                                        <label>Comment</label>
                                        <textarea name="comment" id="comment" style="width: 100%;" cols="30" rows="10" value="{{ old('comment') ?? $advert->comment }}">{{ old('comment') ??$advert->comment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="login-btn-inner">
                                    <div>
                                        @if(auth()->user()->user_types == 1 )
                                        <button style="width: 100%;"
                                            class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                            type="submit">Update</button>
                                        @endif
                                        @if(auth()->user()->user_types != 1)
                                        <button style="width: 100%;"
                                        class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                        type="submit">Update Advert</button> <br><br>
                                        @if($advert->status == 0)
                                        <a onclick = "return(confirm('Are you sure?'))" style="width: 100%;" href="{{ route('advert.approve', $advert->id) }}"
                                        class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                        type="submit">Approve Advert</a>
                                        @endif
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

@endsection
