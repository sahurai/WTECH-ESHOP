<section class="py-4">
    <h2 class="text-xl font-bold mb-2 text-true-dark">{{ $title }}</h2>

    <div class="relative">
        <button
            class="absolute left-2 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-white hover:bg-gray-200 rounded-lg shadow z-20"
            type="button">
            &lt;
        </button>

        <div class="overflow-hidden relative">
            <!-- Fog overlays left and right -->
            <div
                class="pointer-events-none absolute top-0 left-0 h-full w-16 bg-gradient-to-r from-white-2 to-transparent z-10">
            </div>
            <div
                class="pointer-events-none absolute top-0 right-0 h-full w-16 bg-gradient-to-l from-white-2 to-transparent z-10">
            </div>

            <div
                class="overflow-x-auto  scroll-smooth snap-x snap-mandatory flex space-x-5 px-8 py-2 relative z-0 scrollbar-hidden">

                @foreach ($specific as $book)
                    <div class="snap-start shrink-0">
                        @include('partials.book-card', ['book' => $book])
                    </div>
                @endforeach

            </div>
        </div>

        <button
            class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-white hover:bg-gray-200 rounded-lg shadow z-20"
            type="button">
            &gt;
        </button>
    </div>
</section>
