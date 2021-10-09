@component('mail::message')
# Investor Plan Payment Success

Dear {{$user->name}},

Your payment of ${{ $plan_amount }} for the Investor Plan {{ $plan_type }} was recieved. 

Kindly check your crypto provider dashboard for a complete summary of your transaction.

@component('mail::button', ['url' => config('app.url') .'dashboard'])
Head to Dashboard
@endcomponent

Thanks,<br>Earnkrypt Team,<br>
{{ config('app.name') }}
@endcomponent
