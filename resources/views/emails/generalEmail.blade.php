@component('mail::message')
@if($data['type'] == 'advert_created')
Dear Admin,

A new advert has been placed on {{ config('app.name') }}

Details are: <br>
Advert Number: {{ $data['advert_number'] }} <br>
Name: {{ $data['name'] }} <br>
Link: {{ $data['link'] }} <br>
Comment: {{ $data['comment'] }} <br>
Amount Paid: ${{ $data['amount'] }} <br>

@component('mail::button', ['url' => config('app.url') .'dashboard'])
Head to Dashboard to approve<br><br>
@endcomponent

@endif
@if($data['type'] == 'advert_approved')
# Advert Approved

Dear {{ $data['recipient'] }},

Your advert with Advert number <strong>{{ $data['advert_number'] }}</strong> has been approved. <br>

It is now been promoted

Regards,
@endif


@if($data['type'] == 'design_created')
Dear Admin,

A new design has been ordered on {{ config('app.name') }}

Details are: <br>
Design Number: {{ $data['design_number'] }} <br>
Name: {{ $data['name'] }} <br>
Description: {{ $data['description'] }} <br>
Amount Paid: ${{ $data['amount'] }} <br>

@component('mail::button', ['url' => config('app.url') .'dashboard'])
Head to Dashboard to approve<br><br>
@endcomponent

@endif

@if($data['type'] == 'design_status')
Dear {{ $data['recipient'] }},

Status change for your design with number {{ $data['design_number'] }}

The new status is: <strong>{{ $data['status'] }}</strong>

@component('mail::button', ['url' => config('app.url') .'dashboard/design'])
Head to Dashboard to view status<br><br>
@endcomponent
@endif

@if($data['type'] == 'design_complete')
Dear {{ $data['recipient'] }},

Your design with number {{ $data['design_number'] }} is now complete!

@if(isset($data['url']))
Click <a href="{{ $data['url'] }}"><strong>HERE</strong></a> to download your file
@endif

@if(isset($data['file']))
Your design has been attached to this email
@endif

NOTE: <em>Feel free to contact us via {{ \App\Models\Setting::first()->value('design_email') }} for further enquires</em>

@endif

@if($data['type'] == 'advert_payment_received')

Dear {{ $data['name'] }},

Your payment of ${{ $data['amount'] }} has been received as paymment for {{ $data['purpose'] }}.

@component('mail::button', ['url' => config('app.url') .'advert'])
Head to dashboard to make use of your created slot<br><br>
@endcomponent

@endif
@if($data['type'] == 'over_payment_received_for_advert')

Dear {{ $data['name'] }},

Your payment of ${{ $data['amount'] }} has been received as paymment for {{ $data['purpose'] }}.

However, we noticed you made an overpayment of ${{ $data['balance'] }}, this has been added to your wallet for future use.
@component('mail::button', ['url' => config('app.url') .'advert'])
Head to dashboard to make use of your created slot<br><br>
@endcomponent

@endif

@if($data['type'] == 'under_payment_received_for_advert')

Dear {{ $data['name'] }},

Your payment of ${{ $data['amount'] }} has been received as paymment for {{ $data['purpose'] }}.

However, you do no have a slot created yet because you made an underpayment.

Amount Paid: ${{ $data['amount'] }}

Amount Expected: ${{ $data['expected'] }}

Balance:  ${{ $data['balance'] }}.

Please contact the admin via {{ App\Models\Setting::select('official_mail')->first()->value('official_mail') }} to resolve this.
@endif

<br>Earnkrypt Team,<br>
{{ config('app.name') }}
@endcomponent
