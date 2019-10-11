



{{route('verify', $user->verification_token)}}
@component('mail::message')
# Hello {{$user->name}}

Thank you for create an account. Please verify your email Using this link:

@component('mail::button', ['url' => route('verify', $user->verification_token) ])
Verify Your Account
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent
