@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <!-- Main wrapper with responsive padding and max width -->
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div id="flash-message"
                class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-green-100 text-green-800 px-6 py-3 rounded shadow-lg transition-opacity opacity-100">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div id="flash-message"
                class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-green-100 text-green-800 px-6 py-3 rounded shadow-lg transition-opacity opacity-100">
                {{ session('error') }}
            </div>
        @endif


        <!-- Ads section (unchanged) -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4 py-4">
            <div class="relative h-56 group transition-shadow duration-300 hover:shadow-lg">
                <img src="{{ asset('storage/ad.png') }}" alt="Ad" class="absolute w-full h-full object-cover">
            </div>
            <div class="relative h-56 group transition-shadow duration-300 hover:shadow-lg">
                <img src="{{ asset('storage/ad.png') }}" alt="Ad" class="absolute w-full h-full object-cover">
            </div>
            <div class="relative h-56 group transition-shadow duration-300 hover:shadow-lg">
                <img src="{{ asset('storage/ad.png') }}" alt="Ad" class="absolute w-full h-full object-cover">
            </div>
        </section>

        <!-- Bestsellers section -->
        @include('partials.specific-books', ['specific' => $bestsellers, 'title' => 'Bestsellers'])

        <!-- New books section (same logic) -->
        @include('partials.specific-books', ['specific' => $newest, 'title' => 'Newest'])

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    setTimeout(() => {
                        flash.style.transition = 'opacity 0.5s ease-out';
                        flash.style.opacity = '0';
                        setTimeout(() => flash.remove(), 500); // повністю видалити з DOM
                    }, 3000);
                }
            });
        </script>

    </main>
@endsection
