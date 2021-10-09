@component('mail::message')
# Investor Plan Payment Success

Dear {{$user->name}},

Your payment of ${{ $plan_amount }} for the Investor Plan {{ $plan_type }} was recieved. 

However, There was an overpayment of {{ $overpayment }}. This amount has been automatically added to your wallet balance. 

If you do not find it in your wallet balance. Kindly contact the administrator.

Lastly, check your crypto provider dashboard for a complete summary of your transaction.

@component('mail::button', ['url' => config('app.url') .'dashboard'])
Head to Dashboard
@endcomponent

Thanks,

<br>Earnkrpyt Team,<br>
{{ config('app.name') }}
@endcomponent