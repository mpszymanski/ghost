@extends('layouts.app')

@section('content')
<section class="section">
	<div class="container">
		@include('alert::bootstrap')

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

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('.remove-form-button').click(function(e) {
                e.preventDefault()
                var status = confirm('Are you sure, you want to remove this event?')
                if(status) {
                    $(this).parent('form').submit()
                }
            })
        })
    </script>
@endpush