<section class="flex flex-col md:flex-row gap-4 py-8 min-h-[70vh]">
    <!-- Left: Big product image -->
    <div class="w-full min-h-96 md:w-1/3 relative group transition-shadow duration-300 hover:shadow-lg">
        {{-- @foreach ($book->images as $image) --}}
        @if ($book->images->isNotEmpty())
            <img src="{{ asset('assets/homepage/' . $book->images->first()->image_url) }}"
                alt="Book cover for {{ $book->title }}" class="absolute w-full h-full object-cover rounded-md">
        @endif
        {{-- @endforeach --}}
    </div>

    <!-- Right: Main info column -->
    <div class="flex-1 flex flex-col justify-between">
        <!-- Top block: Title, Description, Other Data -->
        <div class="flex flex-col bg-white shadow p-4 h-full rounded-md">
            <!-- Header row: Title and Author and settings button -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-true-dark">{{ $book->title }}</h1>
                    <p class="text-gray-600">by {{ $book->author }}</p>
                </div>
                @if ($isAdmin)
                    <button class="w-6 h-6" title="Edit" onclick="window.location='{{ route('books.edit', $book) }}'">
                        <img src="{{ asset('assets/admin/product-page/edit.svg') }}" alt="Edit">
                    </button>
                @endif
            </div>
            <!-- Description block -->
            <div class="mt-4">
                <h2 class="text-lg font-semibold text-true-dark">Description</h2>
                <p class="text-true-dark mt-2 h-full">
                    {{ $book->description }}
                </p>
            </div>
            <!-- Other Data block -->
            <div class="mt-4">
                <h2 class="text-lg font-semibold text-true-dark">Other Data</h2>
                <ul class="list-disc list-inside text-true-dark mt-2 grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">
                    <li><span class="font-semibold">Genre:</span> {{ $book->genre }}</li>
                    <li><span class="font-semibold">Category:</span> {{ $book->category }}</li>
                    <li><span class="font-semibold">Pages:</span> {{ $book->pages_count }}</li>
                    <li><span class="font-semibold">Year:</span> {{ $book->release_year }}</li>
                    <li><span class="font-semibold">Language:</span> {{ $book->language }}</li>
                    <li><span class="font-semibold">Format:</span> {{ $book->format }}</li>
                    <li><span class="font-semibold">Publisher:</span> {{ $book->publisher }}</li>
                    <li><span class="font-semibold">ISBN:</span>{{ $book->isbn }}</li>
                    <li><span class="font-semibold">Edition:</span> {{ $book->edition }}</li>
                    <li><span class="font-semibold">Dimensions:</span> {{ $book->dimensions }}</li>
                    <li><span class="font-semibold">Weight:</span> {{ $book->weight }}g</li>
                </ul>
            </div>
        </div>
        <!-- Bottom block: Price, quantity selector & Add to Basket (full width) -->
        <div class="mt-4 rounded-md bg-white shadow p-4">
            {{-- Flash messages --}}
            <div>
                @if (session('success'))
                    <div class="mx-auto w-fit px-6 py-3 rounded-md bg-green-100 text-green-800 shadow">
                        {{ session('success') }}
                    </div>
                @endif


                @if ($errors->has('quantity'))
                    <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 font-medium text-center">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('basket.add') }}"
                class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <p class="text-xl font-bold text-true-dark">Price: {{ $book->price }} €</p>
                <div class="flex items-center space-x-2">
                    <label for="quantity" class="text-true-dark font-semibold">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                        max="{{ $book->quantity }}" oninput="this.value=Math.min(this.value, {{ $book->quantity }})"
                        class="w-16 p-2 border border-gray-300 rounded" />
                </div>
                <button type="submit"
                    class="w-full md:w-auto text-true-dark font-semibold py-2 px-6 rounded-md bg-gray-100 hover:bg-gray-200">
                    Add to Basket
                </button>
            </form>

        </div>
    </div>
</section>
