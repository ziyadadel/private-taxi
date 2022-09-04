@component('mail::message')
# Private Taxi Gharghada

We are glad to mail with us and we seriously hope to serve you perfectly.


@component('mail::table')
| Trip info     |
| ------------- |
| Flight num: {{ $trip_name }}  |
| Email: {{ $email }}  |
| Date: {{ $date }}  |
| Size: {{ $size }}  |
| Passengers num: {{ $Passengers_number }}  |
@endcomponent

@component('mail::button', ['url' => 'https://privatetaxihurghada.com/'])
Back To Website
@endcomponent


Thanks,<br>
Private Taxi Gharghada Team
@endcomponent
