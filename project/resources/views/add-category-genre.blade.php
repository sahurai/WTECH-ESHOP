@extends('layouts.app')

@section('title', 'Add {{ $param }}')

@section('content')
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold mb-6 text-true-dark">Add New {{ $param }}</h1>

        <!-- Form with two fields: name and description -->
        <form action="/add-category" method="POST" class="space-y-6" id="add{{ $param }}Form">
            <div>
                <label for="name" class="block text-lg font-semibold text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 w-full p-2 border border-gray-300 rounded"
                    placeholder="Enter strtolower($param) name" required>
            </div>
            <div>
                <label for="description" class="block text-lg font-semibold text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 w-full p-2 border border-gray-300 rounded"
                    placeholder="Enter strtolower($param) description" required></textarea>
            </div>
            <button type="submit"
                class="w-full py-3 px-6 bg-gray-200 hover:bg-gray-300 text-true-dark font-semibold rounded-md">
                Add {{ $param }}
            </button>
        </form>
    </main>

@endsection
