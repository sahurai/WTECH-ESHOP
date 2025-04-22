@extends('layouts.basket')

@section('basketContent')
    <form action="{{ route('checkout.store') }}" method="POST">

        @csrf
        <section class="flex justify-between flex-col md:flex-row px-8 py-4 md:gap-4 gap-2">
            <!-- Shipping section -->
            <fieldset class="flex-1 space-y-2">
                <legend class="text-true-dark text-base sm:text-lg lg:text-xl font-bold border-l-4 border-red-800 ml-2 p-2">
                    Personal details
                </legend>
                <div class="space-y-2 text-sm md:text-base lg:text-lg text-blue">
                    <label class="block">
                        <span class="text-true-dark">E-mail</span>
                        <input type="email" name="email"
                            class="w-full border shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Name</span>
                        <input type="text" name="name"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Surname</span>
                        <input type="text" name="surname"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Phone number</span>
                        <input type="tel" name="number"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                </div>
            </fieldset>
            <!-- Vertical line -->
            <div class="hidden md:block w-1 min-h-20 bg-red-800"></div>
            <!-- Payment section -->
            <section class="flex-1 space-y-2">
                <legend class="text-true-dark text-base sm:text-lg lg:text-xl font-bold border-l-4 border-red-800 ml-2 p-2">
                    Delivery address
                </legend>
                <div class="space-y-2 text-sm md:text-base lg:text-lg text-blue">
                    <label class="block">
                        <span class="text-true-dark">Street and house number</span>
                        <input type="text" name="street"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Postal code or city</span>
                        <input type="text" name="post_code_city"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Country</span>
                        <input type="text" name="country"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                </div>
            </section>
        </section>

        @include('basket.partials.order-buttons', ['step' => 1])
    </form>
@endsection
