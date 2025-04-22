<section class="flex flex-col md:flex-row gap-4 py-8 min-h-[70vh]">
    <!-- Left: Image slider -->
    <div class="w-full md:w-1/3">
        @if($book->images->isNotEmpty())
            <!-- Main image -->
            <img
                id="main-image"
                src="{{ asset('storage/'.$book->images->first()->image_url) }}"
                alt="Cover of {{ $book->title }}"
                class="w-full h-96 object-cover rounded-md shadow mb-4"
            >

            <!-- Thumbnails -->
            <div class="grid grid-cols-4 gap-2">
                @foreach($book->images as $idx => $img)
                    <img
                        src="{{ asset('storage/'.$img->image_url) }}"
                        alt="Thumbnail {{ $idx+1 }}"
                        class="thumb w-full h-24 object-cover rounded-md cursor-pointer border-2 {{ $idx===0 ? 'border-blue-500' : 'border-transparent' }}"
                    >
                @endforeach
            </div>
        @endif
    </div>

    <!-- Right: Main info column -->
    <div class="flex-1 flex flex-col justify-between">
        <!-- Top block: Title, Description, Other Data -->
        <div class="bg-white shadow p-4 rounded-md flex-1 flex flex-col">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-true-dark">{{ $book->title }}</h1>
                    <p class="text-gray-600">by {{ $book->author }}</p>
                </div>
                @if($isAdmin)
                    <button title="Edit" onclick="window.location='{{ route('books.edit', $book) }}'">
                        <img src="{{ asset('assets/admin/product-page/edit.svg') }}" alt="Edit" class="w-6 h-6">
                    </button>
                @endif
            </div>

            <div class="mt-4 flex-1">
                <h2 class="text-lg font-semibold text-true-dark">Description</h2>
                <p class="text-true-dark mt-2">{{ $book->description }}</p>
            </div>

            <div class="mt-4">
                <h2 class="text-lg font-semibold text-true-dark">Other Data</h2>
                <ul class="list-disc list-inside mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2 text-true-dark">
                    <li><strong>Genres:</strong> {{ $book->genres->implode('name', ', ') }}</li>
                    <li><strong>Categories:</strong> {{ $book->categories->implode('name', ', ') }}</li>
                    <li><strong>Pages:</strong> {{ $book->pages_count }}</li>
                    <li><strong>Year:</strong> {{ $book->release_year }}</li>
                    <li><strong>Language:</strong> {{ $book->language }}</li>
                    <li><strong>Format:</strong> {{ $book->format }}</li>
                    <li><strong>Publisher:</strong> {{ $book->publisher }}</li>
                    <li><strong>ISBN:</strong> {{ $book->isbn }}</li>
                    <li><strong>Edition:</strong> {{ $book->edition }}</li>
                    <li><strong>Dimensions:</strong> {{ $book->dimensions }}</li>
                    <li><strong>Weight:</strong> {{ $book->weight }}g</li>
                </ul>
            </div>
        </div>

        <!-- Bottom block: Price, qty & Add to Basket -->
        <div class="mt-4 bg-white shadow p-4 rounded-md">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->has('quantity'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded">
                    {{ $errors->first('quantity') }}
                </div>
            @endif

            <form method="POST" action="{{ route('basket.add') }}"
                  class="flex flex-col md:flex-row items-center justify-between gap-4">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <p class="text-xl font-bold text-true-dark">Price: {{ $book->price }} €</p>

                <div class="flex items-center gap-2">
                    <label for="quantity" class="font-semibold text-true-dark">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                           max="{{ $book->quantity }}"
                           oninput="this.value=Math.min(this.value, {{ $book->quantity }})"
                           class="w-16 p-2 border border-gray-300 rounded" />
                </div>

                <button type="submit"
                        class="py-2 px-6 bg-gray-100 hover:bg-gray-200 rounded font-semibold text-true-dark">
                    Add to Basket
                </button>
            </form>
        </div>
    </div>
</section>

<script>
    (function(){
        const mainImg = document.getElementById('main-image');
        const thumbs  = document.querySelectorAll('.thumb');
        if (!mainImg || !thumbs.length) return;

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                mainImg.src = thumb.src;
                thumbs.forEach(t => {
                    t.classList.replace('border-blue-500', 'border-transparent');
                });
                thumb.classList.replace('border-transparent', 'border-blue-500');
            });
        });
    })();
</script>
