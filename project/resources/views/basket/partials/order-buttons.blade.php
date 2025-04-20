<div class="flex flex-row mx-4 justify-between my-4 sm:m-8 text-sm sm:text-base md:text-lg">
    <a href="#"
        class="bg-dark-violet text-center font-semibold text-white px-2 py-2 rounded hover:bg-gray-600">Continue
        shopping</a>
    @if ($step == 1)
        <button type="submit" class="bg-zinc-700 text-white font-semibold px-2 py-2 rounded hover:bg-gray-600">
            Proceed to checkout
        </button>
    @else
        <a href="#" class="bg-dark-violet text-white font-semibold px-2 py-2 rounded hover:bg-gray-600">Proceed to
            checkout</a>
    @endif

</div>
