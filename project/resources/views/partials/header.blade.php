<!-- Header  -->
<div>
    <!-- Hidden checkbox for mobile menu toggle -->
    <input type="checkbox" id="menu-toggle" class="hidden peer">

    <header class="bg-dark-red p-3 flex items-center justify-between">
        <!-- Left side with logo and title -->
        <div class="flex items-center space-x-4">
            <div class="w-8 h-8 flex items-center justify-center">
                <!-- Logo image -->
                <img src="{{ asset('assets/header/logo.svg') }}" alt="Logo">
            </div>
            <span class="text-white text-lg font-bold">Owl Shop</span>
        </div>

        <!-- Desktop navigation area -->
        <nav class="hidden md:flex items-center space-x-4 w-1/3">
            <!-- Dropdown wrapper for categories -->
            <div class="relative group">
                <!-- Button to show dropdown -->
                <button class="bg-white text-dark-violet px-4 py-2 rounded">
                    Categories
                </button>
                <!-- Dropdown menu: appears on hover, full width -->
                <div class="absolute hidden group-hover:block bg-white shadow-md rounded mt-1 w-full z-20">
                    <!-- Category links (full width) -->
                    @foreach ($categories as $category)
                        <a href="{{ route('category.books', ['id' => $category->id]) }}"
                            class="block w-full px-4 py-2 hover:bg-gray-100">{{ $category->name }}</a>
                    @endforeach

                    {{-- <a href="#" class="block w-full px-4 py-2 hover:bg-gray-100">Fiction</a>
                    <a href="#" class="block w-full px-4 py-2 hover:bg-gray-100">Non-Fiction</a>
                    <a href="#" class="block w-full px-4 py-2 hover:bg-gray-100">Fantasy</a>
                    <a href="#" class="block w-full px-4 py-2 hover:bg-gray-100">Mystery</a>
                    <a href="#" class="block w-full px-4 py-2 hover:bg-gray-100">Sci-Fi</a> --}}
                </div>
            </div>

            <!-- Search input -->
            <input type="text" placeholder="Search..."
                class="px-4 py-2 border border-none bg-white text-dark-violet rounded w-full">
        </nav>

        <!-- Right side with sign up/in, basket and burger menu label for mobile -->
        <div class="flex items-center space-x-4">
            <!-- Sign up/in button always visible -->
            <!-- User button -->
            <button class="w-8 h-8">
                <img src="{{ asset('assets/header/user.svg') }}" alt="User">
            </button>
            <!-- Basket button -->
            <button class="w-8 h-8">
                <img src="{{ asset('assets/header/basket.svg') }}" alt="Basket">
            </button>
            <!-- Burger menu label for mobile (toggles the hidden checkbox) -->
            <label for="menu-toggle" class="md:hidden cursor-pointer">
                <!-- Burger icon with three lines -->
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </label>
        </div>
    </header>

    <!-- Mobile menu: toggled by the checkbox above using peer selector -->
    <div id="mobile-menu" class="md:hidden hidden peer-checked:block bg-gray-50 shadow-md relative">
        <!-- Mobile categories dropdown using checkbox hack -->
        <div class="relative">
            <!-- Hidden checkbox for mobile categories toggle -->
            <input type="checkbox" id="mobile-categories-toggle" class="hidden peer">
            <!-- Label for toggling mobile categories list -->
            <label for="mobile-categories-toggle" class="block px-4 py-2 text-dark-violet border-b cursor-pointer">
                Categories
            </label>
            <!-- Mobile categories list: absolutely positioned, full width -->
            <div id="mobile-categories-list"
                class="hidden peer-checked:block absolute left-0 top-full w-full bg-white shadow-md z-50">
                @foreach ($categories as $category)
                    <a href="{{ route('category.books', ['id' => $category->id]) }}"
                        class="block w-full px-4 py-2 hover:bg-gray-100">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <!-- Mobile search input -->
        <div class="p-4">
            <input type="text" placeholder="Search..." class="w-full px-4 py-2 border border-gray-300 rounded">
        </div>
    </div>
</div>
