@extends('layouts.app')

@section('title', isset($book) ? 'Edit Book' : 'Add Book')

@section('content')
    <!-- Main container with padding and a maximum width -->
    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold mb-6 text-true-dark">{{ isset($book) ? 'Edit Book' : 'Add new Book' }}</h1>

        <!-- Form for editing the book -->
        {{-- {{ isset($book) ? route('books.update', $book['id']) : route('books.store') }} --}}
        <form action="{{ isset($book)
                 ? route('books.update', $book)
                 : route('books.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif
            <!-- Top-level layout: left column vs right column -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Left column: cover, price/quantity (desktop), and buttons (desktop) -->
                <div class="w-full md:w-1/3">
                    <!-- Book Cover label -->
                    <label for="bookCover" class="block text-lg font-semibold text-gray-700 mb-2">
                        Book Cover
                    </label>
                    <!-- Book cover upload area; larger for mobile screens -->
                    <div
                        class="w-full h-64 sm:h-80 md:h-1/2 border-2 border-dashed border-gray-300 flex items-center justify-center">
                        <input type="file" id="bookCover" name="bookCover" accept="image/*"
                            class="w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    <!-- Price and Quantity (visible on md+ screens, hidden on mobile) -->
                    <div class="hidden md:grid mt-4 grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Price (desktop) -->
                        <div>
                            <label for="price" class="block text-lg font-semibold text-gray-700">
                                Price (€)
                            </label>
                            <input type="number" step="0.01" id="price" name="price"
                                value="{{ old('price', $book->price ?? '') }}"
                                class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter price" required />
                        </div>
                        <!-- Quantity (desktop) -->
                        <div>
                            <label for="quantity" class="block text-lg font-semibold text-gray-700">
                                Quantity
                            </label>
                            <input type="number" id="quantity-mobile"
                                value="{{ old('quantity', $book->quantity ?? '') }}" name="quantity"
                                class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter quantity"
                                required />
                        </div>
                    </div>

                    <!-- Desktop buttons for Save / Delete -->
                    <div class="hidden md:flex gap-4 mt-4">
                        @if (isset($book))
                            <!-- Delete Book button (desktop) -->
                            <button type="submit"
                                class="w-full py-3 px-6 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md">
                                Delete Book
                            </button>
                        @endif
                        <!-- Save Changes button (desktop) -->
                        <button type="submit"
                                class="w-full py-3 px-6 bg-gray-200 hover:bg-gray-300 rounded-md">
                            {{ isset($book) ? 'Save Changes' : 'Add Book' }}
                        </button>
                    </div>
                </div>

                <!-- Right column: Title, author, description, other fields -->
                <div class="w-full md:w-2/3 space-y-4">
                    <!-- Book Title -->
                    <div>
                        <label for="bookTitle" class="block text-lg font-semibold text-gray-700">
                            Book Title
                        </label>
                        <input type="text" id="bookTitle" name="title"
                            value="{{ old('title', $book->title ?? '') }}"
                            class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter book title"
                            required />
                    </div>
                    <!-- Author -->
                    <div>
                        <label for="author" class="block text-lg font-semibold text-gray-700">
                            Author
                        </label>
                        <input type="text" id="author" name="author"
                            value="{{ old('author', $book->author ?? '') }}"
                            class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter author name"
                            required />
                    </div>
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-lg font-semibold text-gray-700">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4" class="mt-1 w-full p-2 border border-gray-300 rounded"
                            placeholder="Enter book description" required>{{ old('description', $book->description ?? '') }}</textarea>
                    </div>

                    <!-- Additional fields (pages, genre, category, etc.) -->
                    <div>
                        <h2 class="text-xl font-bold text-true-dark mb-2">Other Data</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-lg font-semibold text-gray-700">
                                    Genre
                                </label>
                                <div class="flex items-center gap-1">
                                    <input type="text" id="genre" name="genre"
                                        value="{{ old('genre', $book->genre ?? '') }}"
                                        class="mt-1 w-full p-2 border border-gray-300 rounded"
                                        placeholder="Enter genre(s)" />
                                    <button type="button"
                                        class="bg-gray-200 hover:bg-gray-300 p-2 text-gray-700 font-bold rounded-md flex items-center justify-center">
                                        +
                                    </button>
                                </div>
                            </div>
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-lg font-semibold text-gray-700">
                                    Category
                                </label>
                                <div class="flex items-center gap-1">
                                    <input type="text" id="category" name="category"
                                        value="{{ old('category', $book->category ?? '') }}"
                                        class="mt-1 w-full p-2 border border-gray-300 rounded"
                                        placeholder="Enter category(s)" />
                                    <button type="button"
                                        class="bg-gray-200 hover:bg-gray-300 p-2 text-gray-700 font-bold rounded-md flex items-center justify-center">
                                        +
                                    </button>
                                </div>
                            </div>
                            <!-- Pages Count -->
                            <div>
                                <label for="pages" class="block text-lg font-semibold text-gray-700">
                                    Pages Count
                                </label>
                                <input type="number" id="pages_count" name="pages_count"
                                       value="{{ old('pages_count', $book->pages_count ?? '') }}"
                                       class="mt-1 w-full p-2 border border-gray-300 rounded"
                                       placeholder="Enter number of pages" />
                            </div>
                            <!-- Release Year -->
                            <div>
                                <label for="year" class="block text-lg font-semibold text-gray-700">
                                    Release Year
                                </label>
                                <input type="number" id="$release_year" name="$release_year"
                                    value="{{ old('release_year', $book->release_year ?? '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter release year" />
                            </div>
                            <!-- Language -->
                            <div>
                                <label for="language" class="block text-lg font-semibold text-gray-700">
                                    Language
                                </label>
                                <input type="text" id="language" name="language"
                                    value="{{ old('language', $book->language ?? '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter language" />
                            </div>
                            <!-- Format -->
                            <div>
                                <label for="format" class="block text-lg font-semibold text-gray-700">
                                    Format
                                </label>
                                <input type="text" id="format" name="format"
                                    value="{{ old('format', $book->format ?? '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter format" />
                            </div>
                            <!-- Publisher -->
                            <div>
                                <label for="publisher" class="block text-lg font-semibold text-gray-700">
                                    Publisher
                                </label>
                                <input type="text" id="publisher" name="publisher"
                                    value="{{ old('publisher', $book->publisher ?? '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded"
                                    placeholder="Enter publisher" />
                            </div>
                            <!-- ISBN -->
                            <div>
                                <label for="isbn" class="block text-lg font-semibold text-gray-700">
                                    ISBN
                                </label>
                                <input type="text" id="isbn" name="isbn"
                                    value="{{ old('isbn', $book->isbn ?? '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter ISBN" />
                            </div>
                            <!-- Edition -->
                            <div>
                                <label for="edition" class="block text-lg font-semibold text-gray-700">
                                    Edition
                                </label>
                                <input type="text" id="edition" name="edition"
                                    value="{{ old('edition', $book->edition ?? '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter edition" />
                            </div>
                            <!-- Dimensions -->
                            <div>
                                <label for="dimensions" class="block text-lg font-semibold text-gray-700">
                                    Dimensions
                                </label>
                                <input type="text" id="dimensions" name="dimensions"
                                    value="{{ old('dimensions', $book->dimensions ?? '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="e.g. 15x21 cm" />
                            </div>
                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-lg font-semibold text-gray-700">
                                    Weight
                                </label>
                                <input type="text" id="weight" name="weight"
                                    value="{{ old('weight', isset($book->weight) ? $book->weight . 'g' : '') }}"
                                    class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="e.g. 500g" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile-only price/quantity and buttons at the bottom of the form -->
            <div class="block md:hidden mt-6 space-y-4">
                <!-- Price and Quantity (mobile version) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Price (mobile) -->
                    <div>
                        <label for="price-mobile" class="block text-lg font-semibold text-gray-700">
                            Price (€)
                        </label>
                        <!-- Use the same name if you want a single final price value.
                                                                           If you want them separate, use a different name. -->
                        <input type="number" step="0.01" id="price-mobile" name="price"
                            value="{{ old('price', $book->price ?? '') }}"
                            class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter price" />
                    </div>
                    <!-- Quantity (mobile) -->
                    <div>
                        <label for="quantity-mobile" class="block text-lg font-semibold text-gray-700">
                            Quantity
                        </label>
                        <input type="number" id="quantity-mobile"
                            value="{{ old('quantity', $book->quantity ?? '') }}" name="quantity"
                            class="mt-1 w-full p-2 border border-gray-300 rounded" placeholder="Enter quantity" />
                    </div>
                </div>

                <!-- Mobile buttons for Delete / Save -->
                <div class="flex gap-4">
                    <!-- Delete Book button (mobile) -->
                    @if (isset($book))
                        <button type="submit"
                            class="w-full py-3 px-6 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md">
                            Delete Book
                        </button>
                    @endif
                    <button type="submit"
                            class="w-full py-3 px-6 bg-gray-200 hover:bg-gray-300 rounded-md">
                        {{ isset($book) ? 'Save Changes' : 'Add Book' }}
                    </button>
                </div>
            </div>
        </form>
    </main>

@endsection
