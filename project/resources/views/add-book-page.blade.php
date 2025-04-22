@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold mb-6 text-true-dark">Add New Book</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('books.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/3">
                    <label for="images" class="block text-lg font-semibold text-gray-700 mb-2">
                        Upload Images
                    </label>
                    <input type="file"
                           id="images"
                           name="images[]"
                           accept="image/*"
                           multiple
                           class="block w-full p-2 border border-gray-300 rounded mb-6" />

                    <label for="price" class="block text-lg font-semibold text-gray-700">Price (€)</label>
                    <input type="number" step="0.01"
                           id="price" name="price"
                           value="{{ old('price') }}"
                           class="block w-full p-2 border border-gray-300 rounded mb-4"
                           required />

                    <label for="quantity" class="block text-lg font-semibold text-gray-700">Quantity</label>
                    <input type="number"
                           id="quantity" name="quantity"
                           value="{{ old('quantity') }}"
                           class="block w-full p-2 border border-gray-300 rounded mb-6"
                           required />

                    <button type="submit"
                            class="w-full py-3 px-6 bg-gray-200 hover:bg-gray-300 rounded-md">
                        Add Book
                    </button>
                </div>

                <div class="w-full md:w-2/3 space-y-4">
                    <div>
                        <label for="title" class="block text-lg font-semibold text-gray-700">Book Title</label>
                        <input type="text"
                               id="title" name="title"
                               value="{{ old('title') }}"
                               class="mt-1 w-full p-2 border border-gray-300 rounded"
                               required />
                    </div>

                    <div>
                        <label for="author" class="block text-lg font-semibold text-gray-700">Author</label>
                        <input type="text"
                               id="author" name="author"
                               value="{{ old('author') }}"
                               class="mt-1 w-full p-2 border border-gray-300 rounded"
                               required />
                    </div>

                    <div>
                        <label for="description" class="block text-lg font-semibold text-gray-700">Description</label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="mt-1 w-full p-2 border border-gray-300 rounded"
                                  required>{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pages_count" class="block text-lg font-semibold text-gray-700">Pages Count</label>
                            <input type="number"
                                   id="pages_count" name="pages_count"
                                   value="{{ old('pages_count') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="release_year" class="block text-lg font-semibold text-gray-700">Release Year</label>
                            <input type="number"
                                   id="release_year" name="release_year"
                                   value="{{ old('release_year') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="language" class="block text-lg font-semibold text-gray-700">Language</label>
                            <input type="text"
                                   id="language" name="language"
                                   value="{{ old('language') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="format" class="block text-lg font-semibold text-gray-700">Format</label>
                            <input type="text"
                                   id="format" name="format"
                                   value="{{ old('format') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    <div>
                        <label for="publisher" class="block text-lg font-semibold text-gray-700">Publisher</label>
                        <input type="text"
                               id="publisher" name="publisher"
                               value="{{ old('publisher') }}"
                               class="mt-1 w-full p-2 border border-gray-300 rounded" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="isbn" class="block text-lg font-semibold text-gray-700">ISBN</label>
                            <input type="text"
                                   id="isbn" name="isbn"
                                   value="{{ old('isbn') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="edition" class="block text-lg font-semibold text-gray-700">Edition</label>
                            <input type="text"
                                   id="edition" name="edition"
                                   value="{{ old('edition') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="dimensions" class="block text-lg font-semibold text-gray-700">Dimensions</label>
                            <input type="text"
                                   id="dimensions" name="dimensions"
                                   value="{{ old('dimensions') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="weight" class="block text-lg font-semibold text-gray-700">Weight (g)</label>
                            <input type="number"
                                   id="weight" name="weight"
                                   value="{{ old('weight') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    <fieldset class="mt-4">
                        <legend class="text-lg font-semibold text-gray-700 mb-2">Genres</legend>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($genres as $genre)
                                <label class="inline-flex items-center">
                                    <input type="checkbox"
                                           name="genres[]"
                                           value="{{ $genre->id }}"
                                           {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}
                                           class="form-checkbox" />
                                    <span class="ml-2">{{ $genre->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <fieldset class="mt-4">
                        <legend class="text-lg font-semibold text-gray-700 mb-2">Categories</legend>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($categories as $category)
                                <label class="inline-flex items-center">
                                    <input type="checkbox"
                                           name="categories[]"
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                           class="form-checkbox" />
                                    <span class="ml-2">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </main>
@endsection
