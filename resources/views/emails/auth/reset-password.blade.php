<x-mail::message>
<p>Hi <b>{{ $user->full_name }}</b>,</p>

<p>Your password reset code is <b>{{ $user->reset_code }}</b></p>

<p>Please do not share this code with anyone.</p>

<p>Thanks,</p>

{{ config('app.name') }}
</x-mail::message>
