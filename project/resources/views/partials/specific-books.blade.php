<section class="py-4">
    <h2 class="text-xl font-bold mb-2 text-true-dark">{{ $title }}</h2>

    <div class="relative">
        <button id="scrollLeft-{{ $title }}"
            class="absolute left-2 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-white hover:bg-gray-200 rounded-lg shadow z-20"
            type="button">
            &lt;
        </button>

        <div id="carousel-{{ $title }}" class="overflow-hidden relative">
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

        <button id="scrollRight-{{ $title }}"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-2 bg-white hover:bg-gray-200 rounded-lg shadow z-20"
            type="button">
            &gt;
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const title = @json($title);
            const scrollContainer = document.querySelector(`#carousel-${title} .overflow-x-auto`);

            const cardWidth = scrollContainer.querySelector('.shrink-0')?.offsetWidth || 300;



            document.getElementById(`scrollLeft-${title}`).addEventListener('click', () => {
                scrollContainer.scrollBy({
                    left: -cardWidth * 2,
                    behavior: 'smooth'
                });
            });
            document.getElementById(`scrollRight-${title}`).addEventListener('click', () => {
                scrollContainer.scrollBy({
                    left: cardWidth * 2,
                    behavior: 'smooth'
                });
            });


        })
    </script>
</section>
