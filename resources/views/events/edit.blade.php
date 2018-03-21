@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        <form action="{{ route('events.update', $event) }}" method="POST">
            @method('PUT')
            @csrf
            @include('events.components._form', [
                'title' => 'Edit event',
                'button_label' => 'Save changes',
                'event' => $event,
                'place' => $event->place
            ])
        </form>
    </div>
</section>
@endsection