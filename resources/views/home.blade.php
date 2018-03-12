@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-fluid" id="jumbotron-homepage">
  <div class="container">
        <h1 class="display-4">Welcome in {{ config('app.name') }}!</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi mollitia id consectetur deleniti maxime sapiente, amet aut repellendus nobis ullam quis iusto, hic molestiae temporibus incidunt non iure. Dolorem, eligendi!</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <header class="header">
            <h2>{{ __('Upcoming Events') }}</h2>
        </header>  
        @forelse($upcomin_events as $event)

        @empty
            {{ __('No Upcoming Events for you!') }}
        @endforelse
    </div>
</section>
@endsection
