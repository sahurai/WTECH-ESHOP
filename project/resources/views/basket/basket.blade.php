@extends('layouts.app')

@section('title', 'Owl Shop - Basket')

@section('content')

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 my-12">
        @if (!empty($books))
            <h1 class="ml-2 text-2xl lg:text-2xl font-bold lg:mb-4 text-true-dark">
                Basket
            </h1>

            <!-- User Actions (Sign in & Delete) -->
            <section class="flex justify-end items-center space-x-4 mb-4">
                <!-- Sign in -->
                <a href="#" class="flex items-center space-x-2 text-black hover:text-gray-700 transition">
                    <span>Sign in</span>
                    <img src="{{ asset('assets/basket-page/user-icon.svg') }}" alt="User icon" class="w-6 h-6" />
                </a>

                <!-- Delete Button -->
                <a href="#" class="hover:opacity-80 transition">
                    <img src="{{ asset('assets/basket-page/delete.svg') }}" alt="Delete basket" class="w-6 h-6" />
                </a>
            </section>

            <!-- Basket-table -->
            @include('basket.partials.basket-table')

            @include('basket.partials.order-buttons', ['step' => 0])
        @else
            @include('basket.partials.empty-cart')
        @endif
    </main>
@endsection
