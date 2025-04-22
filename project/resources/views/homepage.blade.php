@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <!-- Main wrapper with responsive padding and max width -->
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Ads section (unchanged) -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4 py-4">
            <div class="relative h-56 group transition-shadow duration-300 hover:shadow-lg">
                <img src="{{ asset('assets/homepage/ad.png') }}" alt="Ad" class="absolute w-full h-full object-cover">
            </div>
            <div class="relative h-56 group transition-shadow duration-300 hover:shadow-lg">
                <img src="{{ asset('assets/homepage/ad.png') }}" alt="Ad" class="absolute w-full h-full object-cover">
            </div>
            <div class="relative h-56 group transition-shadow duration-300 hover:shadow-lg">
                <img src="{{ asset('assets/homepage/ad.png') }}" alt="Ad" class="absolute w-full h-full object-cover">
            </div>
        </section>

        <!-- Bestsellers section -->
        @include('partials.specific-books', ['specific' => $bestsellers, 'title' => 'Bestsellers'])

        <!-- New books section (same logic) -->
        @include('partials.specific-books', ['specific' => $new, 'title' => 'New'])

    </main>
@endsection
