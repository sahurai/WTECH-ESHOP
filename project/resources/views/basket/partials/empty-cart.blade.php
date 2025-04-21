<div class="text-center py-8 sm:py-12 px-4 sm:px-6 lg:px-8 bg-pale-yellow-2 rounded-lg">
    <img src="{{ asset('assets/basket-page/empty-cart.svg') }}" alt="Empty cart"
        class="mx-auto mb-4 w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40 opacity-80 transition duration-300" />

    <p class="text-lg sm:text-xl md:text-2xl font-semibold text-dark-red mb-2">
        Your basket is empty
    </p>

    <p class="text-sm sm:text-base md:text-lg text-gray-700 mb-4">
        Looks like you haven’t added any books yet.
    </p>

    <a href="{{ route('homepage') }}"
        class="inline-block bg-dark-violet text-white font-medium text-sm sm:text-base px-4 py-2 sm:px-6 sm:py-3 rounded hover:bg-gray-600 transition">
        Browse books
    </a>
</div>
