@extends('backend.layouts.admin')
@section('title', 'Referrals')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        @include('layouts.alerts')
                    </div>
                         @if($referralss->count() <= 0)
                        <div class=" text-center">
                            <img src="{{ asset('images/champagne.jpg') }}" alt="" style="width:80px; border-radius: 50%;"><br><br>
                            <p> No referrals, yet. Earn a 5% commission on the first membership payments made by friends you refer.</p>
                            @endif
                            <p><strong>Your referral code is: {{ auth()->user()->username }}</strong> 
                            <button style="border-radius: 10%;" class="btn btn-info btn-lg" onclick="myFunction()">Copy link</button>
                            <input  style="color: #faebd700;background: #fff0; border: #fff0;" type="text" value="{{ config('app.url').'register?ref='. auth()->user()->username }}" id="myInput" >
                        </p>
                        </div>

                        <script>
                            function myFunction() {
                                var copyText = document.getElementById("myInput");
                                copyText.select();
                                copyText.setSelectionRange(0, 99999)
                                document.execCommand("copy");
                                copyText.style.visibility = 'hidden';
                                alert("Referral link copied!");
                            }
                        </script>
                    
                    @if($referralss->count() > 0)
                    <div class="container-fluid">
                      
                    
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Username</th>
                                    <th>Plan</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referralss as $referrals)
                                    <tr>
                                        <td @if(!isset($referrals->plans)) style="color:red" @endif)>{{ $count ++ }}</td>
                                        <td @if(!isset($referrals->plans)) style="color:red" @endif)>{{ $referrals->username }}</td>
                                        <td @if(!isset($referrals->plans)) style="color:red" @endif)>{{ isset($referrals->plans) ? $referrals->plans->title : 'No Plan yet' }}</td>
                                        <td @if(!isset($referrals->plans)) style="color:red" @endif)>{{ $referrals->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
