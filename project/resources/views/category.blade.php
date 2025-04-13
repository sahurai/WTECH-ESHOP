@extends('layouts.app')

@section('title', 'Category')

@section('content')
    <!-- Main content container -->
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Layout with filters on the left (on larger screens) and content on the right -->
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Filters section -->
            @include('partials.filters')

            <!-- Main content: subcategories, sorting, and book list -->
            <div class="flex-1 flex flex-col gap-4">
                <!-- Category header with subcategories -->
                @include('partials.category-header')

                <!-- Sorting section with radio buttons -->
                @include('partials.sorting-sec')

                <!-- Book grid -->
                <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    <!-- Add a new book card -->
                    @if ($isAdmin)
                        @include('partials.add-book-card')
                    @endif

                    <!-- List of books -->
                    @foreach ($books as $book)
                        @include('partials.book-card', ['book' => $book])
                    @endforeach
                </section>
            </div>
        </div>
    </main>
@endsection
