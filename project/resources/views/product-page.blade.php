@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.product-details')

        @include('partials.specific-books', ['specific' => $recommends, 'title' => 'Recommended'])
    </main>
@endsection
