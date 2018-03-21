@include('alert::bootstrap')
<div class="card">
    <div class="card-body">
        <header class="header">
            <div class="row">
                <div class="col-md-8">
                    <h2>
                        {{ $title }}
                    </h2>
                </div>
                <div class="col-md-4 text-right">
                    <span class="switch switch-sm">
                        <label for="switch-public" class="switch-prev">Private Event</label>
                        <input type="checkbox" 
                            class="switch" 
                            name="event[is_public]" 
                            value="1" 
                            id="switch-public"
                            {{ (old('event.id_public') || $event->is_public) ? 'checked' : '' }}>
                        <label for="switch-public">Public Event</label>
                    </span>
                </div>
            </div>
        </header>
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="event-name">Event name</label>
                    <input type="text" class="form-control{{ $errors->has('event.name') ? ' is-invalid' : '' }}"
                        value="{{ old('event.name') ?? $event->name }}"
                        name="event[name]"
                        id="event-name" 
                        placeholder="My awesome party!">
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="event-start-date">Start Date</label>
                        <input type="text" class="form-control{{ $errors->has('event.start_date') ? ' is-invalid' : '' }}"
                            value="{{ old('event.start_date') ?? $event->start_date->format('d.m.Y') }}"
                            name="event[start_date]" 
                            id="event-start-date"
                            placeholder="01.05.2018"
                            data-toggle="datepicker">
                    </div>
                    <div class="col-md-3">
                        <label for="event-start-time">Start Time</label>
                        <input type="text" class="form-control{{ $errors->has('event.start_time') ? ' is-invalid' : '' }}"
                            value="{{ old('event.start_time') ?? $event->f_start_time }}"
                            name="event[start_time]"
                            id="event-start-time"
                            placeholder="12:00">
                    </div>
                    <div class="col-md-3">
                        <label for="event-start-time">End Time</label>
                        <input type="text" class="form-control{{ $errors->has('event.end_time') ? ' is-invalid' : '' }}"
                            value="{{ old('event.end_time') ?? $event->f_end_time }}"
                            name="event[end_time]"
                            id="event-end-time" 
                            placeholder="13:00">
                    </div>
                    <div class="col-md-3">
                        <label for="event-start-time">End Date</label>
                        <input type="text" class="form-control{{ $errors->has('event.end_date') ? ' is-invalid' : '' }}"
                            value="{{ old('event.end_date') ?? $event->end_date->format('d.m.Y') }}"
                            name="event[end_date]"
                            id="event-end-date" 
                            placeholder="01.05.2018"
                            data-toggle="datepicker">
                    </div>
                </div>
                <div class="form-group">
                    <label for="event-description">Description</label>
                    <textarea 
                        class="form-control{{ $errors->has('event.description') ? ' is-invalid' : '' }}" 
                        id="event-description" 
                        name="event[description]"
                        rows="4"
                        maxlength="512">{{ 
                            old('event.description') ?? $event->description 
                    }}</textarea>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="event-limit">Participants limit</label>
                            <input type="number" class="form-control{{ $errors->has('event.participants_limit') ? ' is-invalid' : '' }}"
                                value="{{ old('event.participants_limit') ?? $event->participants_limit }}"
                                name="event[participants_limit]"
                                id="event-limit" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="event-deadline">Allow register until</label>
                            <input type="text" class="form-control{{ $errors->has('event.register_deadline') ? ' is-invalid' : '' }}"
                                value="{{ old('event.register_deadline') ?? $event->register_deadline->format('d.m.Y') }}"
                                name="event[register_deadline]"
                                id="event-deadline"
                                data-toggle="datepicker">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="place-name">Place name</label>
                    <input type="text" class="form-control{{ $errors->has('place.name') ? ' is-invalid' : '' }}"
                        value="{{ old('place.name') ?? $place->name }}"
                        name="place[name]"
                        id="place-name" 
                        placeholder="In my flat!">
                </div>
                <events-coordinates-map
                    lat_name="place[lat]"
                    lng_name="place[lng]"
                    lat="{{ old('place.lat') ?? $place->lat }}"
                    lng="{{ old('place.lng') ?? $place->lng }}"
                ></events-coordinates-map>
            </div>
        </div>
        <button class="btn btn-primary">{{ $button_label }}</button>
    </div>
</div>

@push('topscripts')
    <script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}">
    </script>
@endpush

@push('scripts')
<script type="text/javascript" defer>
    $(function() {
        let date_format = 'dd.mm.yyyy'
        let time_format = 'hh:mm'

        /**
         * GETers and SETers
         */
        let getStartDate = function() {
            let raw_date = $('#event-start-date').val()
            return moment(raw_date, date_format.toUpperCase()).clone()
        }

        let getEndDate = function() {
            let raw_date = $('#event-end-date').val()
            return moment(raw_date, date_format.toUpperCase()).clone()
        }

        let setEndDate = function(m) {
            let date = m.format(date_format.toUpperCase())
            $('#event-end-date').val(date)
        }

        /**
         * Events 
         */
        var init_start_date = getStartDate()
        var init_end_date = getEndDate()

        $('#event-start-date').change(function() {
            let diff = getStartDate().diff(init_start_date, 'minutes')
            let new_end = getEndDate().add(diff, 'minutes')
            setEndDate(new_end)
            console.log(moment().parseZone())
            console.log(diff, new_end)
            init_start_date = getStartDate()
        })

        /**
         * Input masks
         */
        $('#event-start-time').inputmask(time_format)
        $('#event-end-time').inputmask(time_format)
        $('#event-start-date').inputmask(date_format)
        $('#event-end-date').inputmask(date_format)
        $('#event-deadline').inputmask(date_format)
    });
</script>
@endpush