<section class="section">
    <div class="container">
        <header class="header">
            <h2>{{ __('Upcoming Events') }}</h2>
        </header>  
        @forelse($upcomin_events->chunk(3) as $events)
            <div class="card-deck mb-md-3">
                @foreach($events as $event)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $event->start_date }} {{ $event->start_time }}</h6>
                            <p class="card-text">{{ str_limit($event->description, 120) }}</p>
                            <a href="#" class="card-link">{{ __('Read more') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            {{ __('No Upcoming Events for you!') }}
        @endforelse
    </div>
</section>