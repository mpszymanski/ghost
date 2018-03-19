@extends('layouts.app')

@section('content')
<section class="section">
	<div class="container">
		@include('events.components._table', [
			'table_name' => __('My events'),
			'events' => $owned_events
		])
		@include('events.components._table', [
			'table_name' => __('Joined events'),
			'events' => $joined_events
		])
		@include('events.components._table', [
			'table_name' => __('Invitations'),
			'events' => $unconfirmed_events
		])
	</div>
</section>

@endsection