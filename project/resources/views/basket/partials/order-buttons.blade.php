<div class="flex flex-row mx-4 justify-between my-4 sm:m-8 text-sm sm:text-base md:text-lg">
    @if ($step == 0)
        <a href="{{ route('homepage') }}"
            class="bg-dark-violet text-center font-semibold text-white px-2 py-2 rounded hover:bg-gray-600">Continue
            shopping</a>
        <a href="{{ route('checkout.delivery') }}"
            class="bg-dark-violet text-white font-semibold px-2 py-2 rounded hover:bg-gray-600">Proceed to
            checkout</a>
    @elseif ($step == 1)
        <a href="{{ route('basket.index') }}"
            class="bg-dark-violet text-center font-semibold text-white px-2 py-2 rounded hover:bg-gray-600">Back</a>
        <button type="submit"
            class="bg-zinc-700 text-white font-semibold px-2 py-2 rounded hover:bg-gray-600">Proceed</button>
    @elseif ($step == 2)
        <a href="{{ route('checkout.delivery') }}"
            class="bg-dark-violet text-center font-semibold text-white px-2 py-2 rounded hover:bg-gray-600">Back</a>
        <a href="{{ route('checkout.summary') }}"
            class="bg-dark-violet text-white font-semibold px-2 py-2 rounded hover:bg-gray-600">Proceed</a>
    @elseif ($step == 3)
        <a href="{{ route('checkout.shippingpayment') }}"
            class="bg-dark-violet text-center font-semibold text-white px-2 py-2 rounded hover:bg-gray-600">Back</a>
        <form method="POST" action="{{ route('checkout.confirm') }}">
            @csrf
            <button type="submit" class="bg-zinc-700 text-white font-semibold px-2 py-2 rounded hover:bg-gray-600">
                Finish
            </button>
        </form>
    @endif

</div>
