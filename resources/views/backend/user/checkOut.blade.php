@extends('backend.layouts.admin')
@section('title', 'Create Advert with Coinbase')
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
                            <p>Hi {{ auth()->user()->username }}, you are about to pay ${{ $amount }} with coinbase.  <br>
                               <strong>Please note you will be required to enter your email: <em style="color:blue"> {{ auth()->user()->email }}</em> on the next page. </strong> 
                                <div class="login-btn-inner">
                                    <div>
                                        <a href="{{ $link }}" target="_blank" style="width: 100%;"
                                            class="btn btn-sm btn-primary login-submit-cs button-submit btn-submit"
                                             type="submit">Pay Now</a> <br><br><br>
                                        <a href="{{ route($back_route) }}" style="width: 100%;"
                                            class="btn btn-sm btn-info login-submit-cs button-submit btn-submit"
                                             type="submit">Go Back</a>
                                    </div>
                                </div>                         
                            </p>
                           <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
