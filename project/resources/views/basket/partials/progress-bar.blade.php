@php
    $active = 'bg-dark-red text-white-2 border-orange-900';
    $next = 'bg-pale-yellow-2 text-dark-red border-[#DED9B7]';
    $next_line = 'bg-pale-yellow-2';
    $previous = 'bg-dark-red text-white-2 border-orange-700';
    $previous_line = 'bg-dark-red';
@endphp

<div class="flex items-center text-base md:text-lg lg:text-xl">
    <!-- Step 1 -->
    <div
        class="w-22 sm:w-24 md:w-36 lg:w-40 rounded-full px-4 py-2 text-center font-medium border-4 {{ $step == 1 ? $active : $previous }}">
        Checkout
    </div>
    <!-- Connector -->
    <div class="flex-1 h-2 {{ $step > 1 ? $previous_line : $next_line }}"></div>

    <!-- Step 2 -->
    <div
        class="w-22 sm:w-24 md:w-36 lg:w-40 rounded-full px-4 py-2 text-center font-medium border-4 {{ $step == 2 ? $active : ($step == 1 ? $next : $previous) }}">
        Delivery
    </div>
    <!-- Connector -->
    <div class="flex-1 h-2 {{ $step > 2 ? $previous_line : $next_line }}"></div>
    <!-- Step 3 -->
    <div
        class="w-22 sm:w-24 md:w-36 lg:w-40 rounded-full px-4 py-2 text-center font-medium border-4 {{ $step == 3 ? $active : $next }}">
        Summary
    </div>
</div>
