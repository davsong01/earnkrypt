@component('mail::message')

@if($type == 'admin')
# Withdrawal Notification

Dear Admin,

A withdrawal of ${{ $withdrawal->amount }} was initiated by {{ $user->name}}. 

Details below:
    
Amount Requested: ${{ $withdrawal->amount + $withdrawal->commission }} <br>
Commision Fee: ${{ $withdrawal->commission }} <br>
<strong>Expected Amount: ${{ $withdrawal->amount }}</strong>

Kindly login to dashboard to approve withdrawal.

@endif

@if($type == 'investor')
Dear {{ $user->name}},

Your request for withdrawal of ${{ $withdrawal->amount }} has been received. 

Details below:
    
Amount Requested: ${{ $withdrawal->amount + $withdrawal->commission }} <br>
Commision Fee: ${{ $withdrawal->commission }} <br>
<strong>Expected Amount: ${{ $withdrawal->amount }}</strong>

Kindly login to dashboard to monitor  withdrawal status.
@endif

@component('mail::button', ['url' => config('app.url') .'dashboard'])
Head to Dashboard
@endcomponent

Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
