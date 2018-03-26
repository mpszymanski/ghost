@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        @include('alert::bootstrap')

        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('My events') }} [{{ count($owned_events) }}]</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Joined events') }} [{{ count($joined_events) }}]</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">{{ __('Invitations') }} [{{ count($unconfirmed_events) }}]</a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @include('events.components._table', [
                    'events' => $owned_events
                ])
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                @include('events.components._table', [
                    'events' => $joined_events
                ])
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                @include('events.components._table', [
                    'events' => $unconfirmed_events
                ])
            </div>
        </div>

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

            @if($errors->has('emails'))
                $('#invitation-modal').modal('show')
            @endif
        })
    </script>
@endpush