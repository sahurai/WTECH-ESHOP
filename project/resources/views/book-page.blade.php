{{-- resources/views/book-page.blade.php --}}
@extends('layouts.app')

@section('title', isset($book) ? 'Edit Book' : 'Add Book')

@section('content')
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold mb-6 text-true-dark">
            {{ isset($book) ? 'Edit Book' : 'Add New Book' }}
        </h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif

            <div class="flex flex-col md:flex-row gap-6">
                {{-- left column --}}
                <div class="w-full md:w-1/3">
                    {{-- existing images --}}
                    @if(isset($book) && $book->images->count())
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @foreach($book->images as $img)
                                {{-- use storage symlink --}}
                                <img src="{{ asset('storage/'.$img->image_url) }}"
                                     alt="Book image"
                                     class="object-cover w-full h-24 rounded border" />
                            @endforeach
                        </div>
                    @endif

                    {{-- upload multiple --}}
                    <label for="images" class="block text-lg font-semibold text-gray-700 mb-2">
                        Upload Images
                    </label>
                    <input type="file"
                           id="images"
                           name="images[]"
                           accept="image/*"
                           multiple
                           class="block w-full p-2 border border-gray-300 rounded mb-6" />

                    {{-- price --}}
                    <label for="price" class="block text-lg font-semibold text-gray-700">Price (€)</label>
                    <input type="number" step="0.01"
                           id="price" name="price"
                           value="{{ old('price', $book->price ?? '') }}"
                           class="block w-full p-2 border border-gray-300 rounded mb-4"
                           required />

                    {{-- quantity --}}
                    <label for="quantity" class="block text-lg font-semibold text-gray-700">Quantity</label>
                    <input type="number"
                           id="quantity" name="quantity"
                           value="{{ old('quantity', $book->quantity ?? '') }}"
                           class="block w-full p-2 border border-gray-300 rounded mb-6"
                           required />

                    {{-- save / delete --}}
                    <button type="submit"
                            class="w-full py-3 px-6 bg-gray-200 hover:bg-gray-300 rounded-md mb-2">
                        {{ isset($book) ? 'Save Changes' : 'Add Book' }}
                    </button>
                    @if(isset($book))
                        <button type="button"
                                onclick="event.preventDefault(); document.getElementById('delete-form').submit();"
                                class="w-full py-3 px-6 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md">
                            Delete Book
                        </button>
                    @endif
                </div>

                {{-- right column --}}
                <div class="w-full md:w-2/3 space-y-4">
                    {{-- title --}}
                    <div>
                        <label for="title" class="block text-lg font-semibold text-gray-700">Book Title</label>
                        <input type="text"
                               id="title" name="title"
                               value="{{ old('title', $book->title ?? '') }}"
                               class="mt-1 w-full p-2 border border-gray-300 rounded"
                               required />
                    </div>

                    {{-- author --}}
                    <div>
                        <label for="author" class="block text-lg font-semibold text-gray-700">Author</label>
                        <input type="text"
                               id="author" name="author"
                               value="{{ old('author', $book->author ?? '') }}"
                               class="mt-1 w-full p-2 border border-gray-300 rounded"
                               required />
                    </div>

                    {{-- description --}}
                    <div>
                        <label for="description" class="block text-lg font-semibold text-gray-700">Description</label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="mt-1 w-full p-2 border border-gray-300 rounded"
                                  required>{{ old('description', $book->description ?? '') }}</textarea>
                    </div>

                    {{-- pages & year side by side --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pages_count" class="block text-lg font-semibold text-gray-700">Pages Count</label>
                            <input type="number"
                                   id="pages_count" name="pages_count"
                                   value="{{ old('pages_count', $book->pages_count ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="release_year" class="block text-lg font-semibold text-gray-700">Release Year</label>
                            <input type="number"
                                   id="release_year" name="release_year"
                                   value="{{ old('release_year', $book->release_year ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    {{-- language & format side by side --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="language" class="block text-lg font-semibold text-gray-700">Language</label>
                            <input type="text"
                                   id="language" name="language"
                                   value="{{ old('language', $book->language ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="format" class="block text-lg font-semibold text-gray-700">Format</label>
                            <input type="text"
                                   id="format" name="format"
                                   value="{{ old('format', $book->format ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    {{-- publisher full width --}}
                    <div>
                        <label for="publisher" class="block text-lg font-semibold text-gray-700">Publisher</label>
                        <input type="text"
                               id="publisher" name="publisher"
                               value="{{ old('publisher', $book->publisher ?? '') }}"
                               class="mt-1 w-full p-2 border border-gray-300 rounded" />
                    </div>

                    {{-- isbn & edition --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="isbn" class="block text-lg font-semibold text-gray-700">ISBN</label>
                            <input type="text"
                                   id="isbn" name="isbn"
                                   value="{{ old('isbn', $book->isbn ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="edition" class="block text-lg font-semibold text-gray-700">Edition</label>
                            <input type="text"
                                   id="edition" name="edition"
                                   value="{{ old('edition', $book->edition ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    {{-- dimensions & weight --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="dimensions" class="block text-lg font-semibold text-gray-700">Dimensions</label>
                            <input type="text"
                                   id="dimensions" name="dimensions"
                                   value="{{ old('dimensions', $book->dimensions ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                        <div>
                            <label for="weight" class="block text-lg font-semibold text-gray-700">Weight (g)</label>
                            <input type="number"
                                   id="weight" name="weight"
                                   value="{{ old('weight', $book->weight ?? '') }}"
                                   class="mt-1 w-full p-2 border border-gray-300 rounded" />
                        </div>
                    </div>

                    {{-- genres --}}
                    <fieldset class="mt-4">
                        <legend class="text-lg font-semibold text-gray-700 mb-2">Genres</legend>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($genres as $genre)
                                <label class="inline-flex items-center">
                                    <input type="checkbox"
                                           name="genres[]"
                                           value="{{ $genre->id }}"
                                           {{ in_array($genre->id, old('genres', $book->genres->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                           class="form-checkbox" />
                                    <span class="ml-2">{{ $genre->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    {{-- categories --}}
                    <fieldset class="mt-4">
                        <legend class="text-lg font-semibold text-gray-700 mb-2">Categories</legend>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($categories as $category)
                                <label class="inline-flex items-center">
                                    <input type="checkbox"
                                           name="categories[]"
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', $book->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                           class="form-checkbox" />
                                    <span class="ml-2">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>

        {{-- hidden delete form --}}
        @if(isset($book))
            <form id="delete-form" action="{{ route('books.destroy', $book) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </main>
@endsection
