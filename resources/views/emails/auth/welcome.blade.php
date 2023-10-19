<x-mail::message>
<p>Hi <b>{{ $user->full_name }}</b>,</p>

<p>You have successfully created an account on <b>{{ config('app.name') }}</b></p>

<p>Your account verification code is <b>{{ $user->verification_code }}</b></p>

<p>Thanks,</p>

{{ config('app.name') }}
</x-mail::message>
