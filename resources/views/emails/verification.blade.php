@component('mail::message')
# City of Tampere Open311 API

Please verify your email address by clicking the following button to get a API key.

@component('mail::button', ['url' => url('/client/verify/' . $user->verification_key)])
Verify email address
@endcomponent

Cheers,<br>
Tampere Open311
@endcomponent
