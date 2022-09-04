@component('mail::message')
# Private Taxi Gharghada

Hello Mr.Ahmed here is your password reset link

@component('mail::button', ['url' => 'http://127.0.0.1:3000/admin/password-reset?resetToken='.$token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
