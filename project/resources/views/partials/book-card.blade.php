<a href="{{ route('books.show', ['book' => $book['id']]) }}">
    <div class="bg-white shadow rounded-md text-left transition-shadow duration-300 hover:shadow-lg w-40 sm:w-44">
        <!-- Fixed-height container for the book cover -->
        <div class="w-full h-64 overflow-hidden mb-2">
            @if ($book->images->isNotEmpty())
                <img src="{{ asset('assets/homepage/' . $book->images->first()->image_url) }}"
                    alt="Book cover for {{ $book->title }}" class="w-full h-full object-cover">
            @endif
        </div>
        <!-- Book title -->
        <h3 class="text-blue text-sm font-bold leading-tight mb-1 px-2">
            {{ $book->title }}
        </h3>
        <!-- Book author -->
        <p class="text-gray-600 text-sm mb-2 px-2">
            {{ $book->author }}
        </p>
        <!-- Price/discount row -->
        <div class="flex items-center justify-between px-2 pb-2">
            @if (!empty($book->discount))
                <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-semibold">
                    -{{ $book->discount }}%
                </span>
            @else
                {{-- empty span --}}
                <span class="invisible px-2 py-1 rounded text-xs font-semibold">placeholder</span>
            @endif
            <p class="text-true-black font-bold text-sm">
                {{ $book->price }} €
            </p>
        </div>
    </div>
</a>
