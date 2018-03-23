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

		@include('events.components._invitation_modal')
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

            $('#invitation-modal').on('show.bs.modal', function (event) {
			  	var button = $(event.relatedTarget) 
			  	var id = button.data('event')

			  	var modal = $(this)
			  	modal.find('.modal-dialog #event_id').val(id)
			  	console.log(modal.find('.modal-dialog #event_id'), id)
			})
        })
    </script>
@endpush