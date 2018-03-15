@extends('layouts.app')

@section('content')
    @include('home.components._hero')
    @include('home.components._cards')
    @include('home.components._map')
@endsection

@push('topscripts')
    <script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}">
    </script>
@endpush
