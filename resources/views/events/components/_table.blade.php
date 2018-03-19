<div class="card mb-4">
	<div class="card-body">
		<header class="header">
			<div class="row">
				<div class="col-md-8">
					<h2>
						{{ $table_name }}
					</h2>
				</div>
			</div>
		</header>
		<table class="table">
			<tr>
				<th>{{ __('Name') }}</th>
				<th>{{ __('Place') }}</th>
				<th>{{ __('Time') }}</th>
				<th>{{ __('Participents') }}</th>
				<th></th>
			</tr>
			@forelse($events as $event)
				<tr>
					<td>{{ $event->name }}</td>
					<td>{{ $event->place->name }}</td>
					<td>{{ $event->fulldate }}</td>
					<td>
						{{ $event->invitations->where('is_confirmed', 1)->count() }} 
						@if($unconfirmed = $event->invitations->where('is_confirmed', 0)->count())
						     (+{{ $unconfirmed }}) 
						@endif
						/ {{ $event->participants_limit }}</td>
					<td>
						<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Actions') }}</button>
					    <div class="dropdown-menu">
					    	<a href="{{ route('events.show', [$event->id, $event->slug]) }}" class="dropdown-item">Details</a>
					      	@can('edit-event', $event)
								<a href="#" class="dropdown-item">Edit</a>
							@endcan
							<div role="separator" class="dropdown-divider"></div>
					      	@can('invite-to-event', $event)
								<a href="#" class="dropdown-item">
									Invite
								</a>
							@endcan
							@can('join-event', $event)
								<form action="{{ route('events.join', $event) }}" method="post">
									@csrf
									<button type="submit" class="dropdown-item">
										Join
									</button>
								</form>
								<form action="{{ route('events.leave', $event) }}" method="post">
									@csrf
									<button type="submit" class="dropdown-item">
										Refuse
									</button>
								</form>
							@endcan
							@can('leave-event', $event)
								<form action="{{ route('events.leave', $event) }}" method="post">
									@csrf
									<button type="submit" class="dropdown-item">
										Leave
									</button>
								</form>
							@endcan
					      	<div role="separator" class="dropdown-divider"></div>
					      	@can('remove-event', $event)
								<a href="#" class="dropdown-item">
									Remove
								</a>
							@endcan
					    </div>
					</td>
				</tr>
			@empty
				<tr>
					<td>{{ __('No events') }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			@endforelse
		</table>
	</div>
</div>