<section class="space-y-2 bg-pale-yellow-2 px-4 py-4 rounded-lg">
    <!-- First book item  -->
    @foreach ($books as $item)
        <article
            class="flex flex-row sm:flex-row items-center justify-center border-b border-black pb-2 gap-2 text-sm sm:text-base md:text-lg">
            <div class="w-16 h-24 sm:w-24 sm:h-36 max-w-[100px] sm:max-w-[120px] overflow-hidden flex-shrink-0">
                <img src="{{ asset('assets/homepage/' . $item->images->first()->image_url) }}"
                    alt="Book Image for
                    {{ $item->title }}"
                    class="w-full h-full rounded object-cover" />
            </div>
            <!-- Book details -->
            <div class="flex-1 flex flex-col self-start">
                <h2 class="text-blue font-bold leading-tight px-2">
                    {{ $item->title }}
                </h2>
                <p class="text-gray-600 px-2">{{ $item->author }}</p>
            </div>
            <div class="hidden sm:block w-24 h-8 text-center text-md">
                {{ $item->price }} €
            </div>
            <!-- Quantity -->
            <div
                class="flex justify-center items-center border border-gray-300 rounded-lg w-16 h-7 sm:w-24 sm:h-10 bg-dark-violet">
                <button class="text-white sm:px-3 rounded-l-lg hover:bg-gray-600 h-full min-w-4 w-8">
                    -
                </button>
                <span
                    class="bg-pale-yellow px-3 text-blue flex justify-center items-center h-full min-w-4 w-4 sm:w-8">{{ $cart[$item->id] }}</span>
                <button class="text-white sm:px-3 rounded-r-lg hover:bg-gray-600 h-full min-w-4 w-8">
                    +
                </button>
            </div>
            <div class="sm:w-24 sm:h-8 text-center font-medium mx-2 sm:mx-0 md:mx-2 text-blue">
                {{ $cart[$item->id] * $item->price }} €
            </div>
        </article>
    @endforeach
    <!-- Total price -->

    <div class="flex justify-end items-center my-6 px-2 sm:px-4 gap-2 sm:gap-8 md:gap-10">
        <!-- Total price text -->
        <div class="text-base sm:text-lg md:text-xl font-semibold text-blue">
            Total price:
        </div>
        <!-- Total price amount -->
        <div class="text-base sm:text-lg md:text-xl font-bold text-gray-900">
            {{ $totalPrice }}
        </div>
    </div>
</section>
