<x-mail::message>
<p>Hi <b>{{ $user->full_name }}</b>,</p>

<p>Your account has been created on <b>{{ config('app.name') }}</b></p>

<p>Your login credentials are:</p>
<p>Email: {{ $user->email }}</p>
<p>Password: {{ $password }}</p>

@if ($isAdmin)
<x-mail::button :url="config('app.url') . '/admin/login'">
Login
</x-mail::button>
@endif

<p>Thanks,</p>

{{ config('app.name') }}
</x-mail::message>
