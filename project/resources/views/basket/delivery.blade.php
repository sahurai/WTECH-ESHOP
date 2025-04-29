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
                            value="{{ old('email') ?? (Auth::check() ? Auth::user()->email ?? '' : '') }}"
                            class="w-full border shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            {{ Auth::check() ? 'readonly' : '' }} required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Name</span>
                        <input type="text" name="name"
                            value="{{ old('name') ?? (explode(' ', Auth::user()->username ?? '')[0] ?? '') }}"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            {{ Auth::check() ? 'readonly' : '' }} required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Surname</span>
                        <input type="text" name="surname"
                            value="{{ old('surname') ?? (explode(' ', Auth::user()->username ?? '')[1] ?? '') }}"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            {{ Auth::check() ? 'readonly' : '' }} required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Phone number</span>
                        <input type="tel" name="number" value="{{ old('number') ?? optional(Auth::user())->number }}"
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
                        <input type="text" name="address_line"
                            value="{{ old('address_line') ?? optional(Auth::user())->address_line }}"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Postal code</span>
                        <input type="text" name="postal_code"
                            value="{{ old('postal_code') ?? optional(Auth::user())->postal_code }}"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">City</span>
                        <input type="text" name="city" value="{{ old('city') ?? optional(Auth::user())->city }}"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                    <label class="block">
                        <span class="text-true-dark">Country</span>
                        <input type="text" name="country"
                            value="{{ old('country') ?? optional(Auth::user())->country }}"
                            class="w-full border border-orange-300 shadow-md shadow-orange-200 rounded-md p-2 focus:ring focus:ring-orange-300"
                            required />
                    </label>
                </div>
            </section>
        </section>

        @include('basket.partials.order-buttons', ['step' => 1])
    </form>
@endsection
