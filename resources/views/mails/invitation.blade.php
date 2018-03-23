@component('mail::message')
# Hi, {{ $user->nick }}<br>
{{ $inviting->nick }} Was invited You to join event<br>
<strong>{{ $event->name }}</strong>

@if($message)
@component('mail::panel')
	{{ $message }}
@endcomponent
@endif


@component('mail::button', ['url' => $url])
	Check event
@endcomponent

@endcomponent