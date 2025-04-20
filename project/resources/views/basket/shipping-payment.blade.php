@extends('layouts.basket')

@section('basketContent')
    <section class="flex justify-between flex-col md:flex-row px-8 py-4 md:gap-4 gap-2">
        <!-- Shipping section -->
        <section class="flex-1 space-y-2">
            <h2 class="text-true-dark text-base sm:text-lg lg:text-xl font-bold border-l-4 border-red-800 ml-2 p-2">
                Shipping
            </h2>
            <div class="space-y-2 text-sm md:text-base lg:text-lg text-blue">
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border transition shadow-md shadow-orange-200">
                    <input type="radio" name="shipping" class="form-radio accent-red-400" />
                    <span class="text-blue">Standard Shipping (5-7 days)</span>
                </label>
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border shadow-md shadow-orange-200">
                    <input type="radio" name="shipping" class="form-radio accent-red-400" />
                    <span class="text-blue">Express Shipping (2-3 days)</span>
                </label>
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border shadow-md shadow-orange-200">
                    <input type="radio" name="shipping" class="form-radio accent-red-400" />
                    <span class="text-blue">Next Day Delivery</span>
                </label>
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border shadow-md shadow-orange-200">
                    <input type="radio" name="shipping" class="form-radio accent-red-400" />
                    <span class="text-blue">Another</span>
                </label>
            </div>
        </section>
        <!-- Vertical line -->
        <div class="hidden md:block w-1 min-h-20 bg-red-800"></div>
        <!-- Payment section -->
        <section class="flex-1 space-y-2">
            <h2 class="text-true-dark text-base sm:text-lg lg:text-xl font-bold border-l-4 border-red-800 ml-2 p-2">
                Payment
            </h2>
            <div class="space-y-2 text-sm md:text-base lg:text-lg text-blue">
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border shadow-md shadow-orange-200">
                    <input type="radio" name="payment" class="form-radio accent-red-400" />
                    <span class="text-blue">Debit card</span>
                </label>
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border shadow-md shadow-orange-200">
                    <input type="radio" name="payment" class="form-radio accent-red-400" />
                    <span class="text-blue">PayPal</span>
                </label>
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border shadow-md shadow-orange-200">
                    <input type="radio" name="payment" class="form-radio accent-red-400" />
                    <span class="text-blue">Google Pay</span>
                </label>
                <label
                    class="flex items-center py-3 px-4 space-x-2 hover:bg-gray-100 rounded-lg border shadow-md shadow-orange-200">
                    <input type="radio" name="payment" class="form-radio accent-red-400" />
                    <span class="text-blue">Apple Pay</span>
                </label>
            </div>
        </section>
    </section>
    @include('basket.partials.order-buttons')
@endsection
