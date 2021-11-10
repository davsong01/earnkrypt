@extends('backend.layouts.admin')
@section('content')
<div class="container-fluid" style="margin: auto;">
    <div class="card">
        <div class="card-header">
            <div class="section-header wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">  
            <!-- SECTION TITLE -->
            <h3 class="dark-text">Payment Status</h3>
            <div class="colored-line">
            </div>
                <div class="section-description">
                    {{-- @if(isset($type) && $type == 1) --}}
                        @if($status == 'CONFIRMED')
                        Your Payment is now <span style="color:green"><strong>{{ $status }}</strong></span> No need to refresh this page <br>
                        Please <a href="{{ route('promote.index') }}">click here</a> to promote a task
                        @else
                        Hold on a second! Your payment was detected but confirmation is <span style="color:red"><strong>{{ $status }}</strong></span>. Confirmation of transactions can be nearly instant for low-value transactions, but can take up to an hour, or even days, depending on the value of the bitcoin you are sending. The general rule of thumb is to wait for six confirmations. <br>
                        <strong>Continue to refresh this page to get updated transaction status</strong> or <a href="/selectplans"><strong>Make payment again</strong></a>
                        @endif
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
