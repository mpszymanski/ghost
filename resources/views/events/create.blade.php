@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            @include('events.components._form', [
                'title' => 'Create event',
                'button_label' => 'Create new event',
                'event' => new App\Event([
                    'start_date' => Carbon\Carbon::now(),
                    'end_date' => Carbon\Carbon::now(),
                    'start_time' => Carbon\Carbon::now()->minute(0)->format('H:i:s'),
                    'end_time' => Carbon\Carbon::now()->addHour()->minute(0)->format('H:i:s'),
                    'user_id' => Auth::user()->id,
                    'register_deadline' => Carbon\Carbon::now(),
                ]),
                'place' => new App\Place
            ])
        </form>
    </div>
</section>
@endsection