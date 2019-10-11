@component('mail::message')
# Hello {{$user->name}}

You Changed your email, So We Need to verify this new Address. Please use the link below:

@component('mail::button', ['url' => route('verify', $user->verification_token) ])
Verify Your Account
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent
