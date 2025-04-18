@extends('layouts.app')

@section('title', 'Product Page')

@section('content')
    <!-- Main wrapper with responsive padding and max width -->
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Product details section -->
        @include('partials.product-details')

        <!-- Recommendation Section -->
        @include('partials.specific-books', ['specific' => $recommends, 'title' => 'Recommended'])
    </main>
@endsection
