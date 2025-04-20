@extends('layouts.basket')

@section('basketContent')
    <section class="flex justify-between flex-col md:flex-row px-2 sm:px-8 py-4 pb-2 md:gap-4 gap-2">
        <section class="sm:w-3/5 rounded-lg space-y-2 mb-8 sm:mb-0">
            <h2 class="text-true-dark text-base sm:text-lg lg:text-xl font-bold border-l-4 border-red-800 ml-2 p-2">
                Orders
            </h2>
            <!-- Basket -->
            <section class="space-y-2 bg-pale-yellow-2 px-3 sm:px-4 py-4 rounded-lg">
                <!-- First book item  -->
                <article
                    class="flex flex-row sm:flex-row items-center border-b border-black pb-2 gap-2 text-sm sm:text-base">
                    <div class="w-24 h-32 sm:w-20 sm:h-32 max-w-[80px] sm:max-w-[100px] overflow-hidden flex-shrink-0">
                        <img src="../assets/homepage/book-cover-1.png" alt="Book Image"
                            class="w-full h-full rounded object-cover" />
                    </div>
                    <!-- Book details -->
                    <div class="flex-1 flex flex-col self-start">
                        <h2 class="text-blue font-bold leading-tight px-2">
                            Hunting Adelina
                        </h2>
                        <p class="text-gray-600 px-2 text-xs sm:text-sm">
                            H. D. Carlton
                        </p>
                    </div>

                    <!-- Quantity -->

                    <div class="sm:w-20 text-center">2 ks</div>

                    <div class="sm:w-20 text-center font-medium mx-1 sm:mx-0 text-blue">
                        36.06 €
                    </div>
                </article>
                <!-- Second book item  -->
                <article
                    class="flex flex-row sm:flex-row items-center justify-center border-b border-black pb-2 gap-2 sm:gap-2 text-sm sm:text-base">
                    <div class="w-20 h-32 sm:w-20 sm:h-32 max-w-[80px] sm:max-w-[100px] overflow-hidden flex-shrink-0">
                        <img src="../assets/homepage/book-cover-3.png" alt="Book Image"
                            class="w-full h-full rounded object-cover" />
                    </div>
                    <!-- Book details -->
                    <div class="flex-1 flex flex-col self-start">
                        <h2 class="text-blue font-bold leading-tight px-2">
                            Wild Side
                        </h2>
                        <p class="text-gray-600 px-2">Elsie Silver</p>
                    </div>

                    <!-- Quantity -->
                    <div class="sm:w-20 text-center text-md">1 ks</div>
                    <div class="sm:w-20 text-center font-medium mx-1 sm:mx-0 text-blue">
                        12.00 €
                    </div>
                </article>

                <!-- Total price -->
                <div class="flex justify-end items-center my-6 px-2 sm:px-4 gap-2 sm:gap-8 md:gap-10">
                    <!-- Total price text -->
                    <div class="text-base sm:text-lg font-semibold text-blue">
                        Total price:
                    </div>
                    <!-- Total price amount -->
                    <div class="text-base sm:text-lg font-bold text-gray-900">
                        $48.06
                    </div>
                </div>
            </section>
        </section>
        <!-- Vertical line -->
        <div class="hidden md:block w-1 min-h-20 bg-red-800"></div>
        <!-- Summary section -->
        <section class="sm:w-2/5 space-y-6">
            <h2 class="text-true-dark text-base sm:text-lg lg:text-xl font-bold border-l-4 border-red-800 ml-2 p-2">
                Info
            </h2>
            <div class="flex items-center space-x-4">
                <img src="../assets/summary-page/user.svg" alt="Delivery Icon" class="w-12 h-12" />
                <div>
                    <h3 class="font-bold">Delivery address</h3>
                    <span class="block">Ivan Petrov</span>
                    <span class="blox text-sm">Stare Grunty 53, 84104 Bratislava, 0951921012, Slovakia</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <img src="../assets/summary-page/delivery-truck.svg" alt="Shipping Icon" class="w-12 h-12" />
                <div>
                    <h3 class="font-bold">Shipping</h3>
                    <span>Next Day Delivery</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <img src="../assets/summary-page/wallet.svg" alt="Payment Icon" class="w-12 h-12" />
                <div>
                    <h3 class="font-bold">Payment</h3>
                    <span>Google Pay</span>
                </div>
            </div>
        </section>
    </section>
    @include('basket.partials.order-buttons')
@endsection
