@component('mail::message')
# Private Taxi Gharghada

We are glad to mail with us and we seriously hope to serve you perfectly.


@component('mail::table')
| Trip info     |
| ------------- |
| Email: {{ $email }}  |
| Flight num: {{ $flight_number }}  |
| Date: {{ $date }}  |
| Size: {{ $size }}  |
| Name on board:{{ $name_on_board }}  |
| Passengers num: {{ $Passengers_number }}  |
| From: {{ $too }}  |
{{-- | From: {{ $from2 }}  | --}}
@endcomponent

@component('mail::button', ['url' => 'https://privatetaxihurghada.com/'])
Back To Website
@endcomponent


Thanks,<br>
Private Taxi Gharghada Team
@endcomponent
