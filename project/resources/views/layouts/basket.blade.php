@extends('layouts.app')
@section('title', 'Owl shop')
@section('content')
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 my-12 gap-x-4 w-full">
        <!-- Progress bar -->
        @include('basket.partials.progress-bar')

        @yield('basketContent')
    </main>
@endsection
