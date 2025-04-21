@extends('layouts.app')

@section('title', 'Owl Shop - Basket')

@section('content')

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 my-12">
        @if (!empty($books))
            <h1 class="ml-2 text-2xl lg:text-2xl font-bold lg:mb-4 text-true-dark">
                Basket
            </h1>

            <!-- User Actions ( Delete) -->
            <section class="flex justify-end items-center space-x-4 mb-4">

                <!-- Delete Button -->
                <form action="{{ route('basket.clear') }}" method="POST"
                    onsubmit="return confirm('Clear the entire basket?')">
                    @csrf
                    <button type="submit" class="hover:opacity-80 transition">
                        <img src="{{ asset('assets/basket-page/delete.svg') }}" alt="Delete basket" class="w-6 h-6" />
                    </button>
                </form>
            </section>

            <!-- Basket-table -->
            @include('basket.partials.basket-table')

            @include('basket.partials.order-buttons', ['step' => 0])
        @else
            @include('basket.partials.empty-cart')
        @endif
    </main>
@endsection
