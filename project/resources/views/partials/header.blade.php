<!-- Header component -->
<div>
    <!-- ─────────── TOP BAR ─────────── -->
    <header class="bg-dark-red px-4 py-3 flex items-center justify-between">
        {{-- Logo + title --}}
        <a href="/">
            <div class="flex items-center gap-3">
                <img class="w-8 h-8" src="{{ asset('assets/header/logo.svg') }}" alt="Logo">
                <span class="text-lg font-bold text-white">Owl Shop</span>
            </div>
        </a>

        {{-- Desktop NAV --}}
        <nav class="hidden md:flex items-center gap-6 w-1/2">
            {{-- Categories button --}}
            <div class="relative">
                <button id="categories-btn" class="flex items-center gap-1 px-4 py-2 rounded-md bg-white text-dark-red">
                    Categories
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 0 1 1.1 1.02l-4.25 4.25a.75.75 0 0 1-1.06 0L5.21 8.25a.75.75 0 0 1 .02-1.04z" />
                    </svg>
                </button>
                <div id="categories-menu"
                    class="absolute left-0 top-full mt-1 w-56 hidden rounded-md bg-white shadow-lg z-30">
                    @foreach ($categories as $category)
                        <a href="{{ route('category.books', ['id' => $category->id]) }}"
                            class="block px-4 py-2 hover:bg-gray-100 hover:rounded-md">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('books.search') }}">
                <input name="query" type="text" placeholder="Search…"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none"
                    value="{{ request('query') }}">
            </form>
        </nav>

        {{-- Desktop profile --}}
        <div class="hidden md:flex items-center">
            <div class="relative">
                @guest
                    <button id="profile-btn" class="px-4 py-2 rounded-md bg-white text-dark-red">
                        Profile
                    </button>
                    <div id="profile-menu"
                        class="absolute right-0 top-full mt-1 hidden w-44 rounded-md bg-white shadow-lg z-30">
                        @include('partials.drop-menu-guest')
                    </div>
                @else
                    <button id="user-btn" class="px-4 py-2 rounded-md bg-white text-dark-red">
                        {{ Auth::user()->username }}
                    </button>
                    <div id="user-menu"
                        class="absolute right-0 top-full mt-1 hidden w-44 rounded-md bg-white shadow-lg z-30">
                        @include('partials.drop-menu-user')
                    </div>
                @endguest
            </div>
        </div>

        {{-- Burger (mobile) --}}
        <button id="mobile-menu-btn" class="md:hidden text-white">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- ─────────── MOBILE MENU ─────────── -->
    <div id="mobile-menu" class="fixed inset-0 bg-gray-50 translate-y-[-110%] transition-transform md:hidden z-40">
        {{-- Close mobile menu --}}
        <button id="mobile-close" class="absolute top-4 right-4 text-dark-violet">
            <svg class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 8.586L15.657 2.93a1 1 0 111.414 1.414L11.414 10l5.657 5.657a1 1 0 01-1.414 1.414L10 11.414l-5.657 5.657a1 1 0 01-1.414-1.414L8.586 10 2.93 4.343a1 1 0 011.414-1.414L10 8.586z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        {{-- Account card --}}
        <div class="mx-4 mt-6 rounded-lg bg-white shadow-md">
            @guest
                @include('partials.drop-menu-guest')
            @else
                <span class="block px-4 py-3 font-medium text-dark-red">{{ Auth::user()->username }}</span>
                @include('partials.drop-menu-user')
            @endguest
        </div>

        {{-- Categories accordion --}}
        <button id="mobile-categories-btn"
            class="mx-4 mt-6 w-[calc(100%-2rem)] text-left px-4 py-3 rounded-lg bg-white shadow-md flex items-center justify-between">
            Categories
            <svg id="mobile-categories-arrow" class="w-4 h-4 transition-transform" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 0 1 1.1 1.02l-4.25 4.25a.75.75 0 0 1-1.06 0L5.21 8.25a.75.75 0 0 1 .02-1.04z" />
            </svg>
        </button>
        <div id="mobile-categories-list"
            class="mx-4 overflow-hidden max-h-0 transition-[max-height] bg-white rounded-b-lg shadow-md">
            @foreach ($categories as $category)
                <a href="{{ route('category.books', ['id' => $category->id]) }}"
                    class="block px-6 py-3 hover:bg-gray-100">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Search --}}
        <div class="mt-6 px-4">
            <input type="text" placeholder="Search…"
                class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none">
        </div>
    </div>
</div>

<!-- ─────────── JS ─────────── -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        /* desktop categories */
        const catBtn = document.getElementById('categories-btn');
        const catMenu = document.getElementById('categories-menu');
        catBtn.addEventListener('click', e => {
            e.stopPropagation();
            catMenu.classList.toggle('hidden');
        });
        document.addEventListener('click', e => {
            if (!catMenu.contains(e.target)) catMenu.classList.add('hidden');
        });

        /* desktop profile (guest) */
        const pBtn = document.getElementById('profile-btn');
        const pMenu = document.getElementById('profile-menu');
        if (pBtn && pMenu) {
            pBtn.addEventListener('click', e => {
                e.stopPropagation();
                pMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', e => {
                if (!pMenu.contains(e.target)) pMenu.classList.add('hidden');
            });
        }

        /* desktop profile (auth) */
        const uBtn = document.getElementById('user-btn');
        const uMenu = document.getElementById('user-menu');
        if (uBtn && uMenu) {
            uBtn.addEventListener('click', e => {
                e.stopPropagation();
                uMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', e => {
                if (!uMenu.contains(e.target)) uMenu.classList.add('hidden');
            });
        }

        /* mobile menu */
        const mobBtn = document.getElementById('mobile-menu-btn');
        const mobMenu = document.getElementById('mobile-menu');
        const mobClose = document.getElementById('mobile-close');
        mobBtn.addEventListener('click', () => mobMenu.style.transform = 'translateY(0)');
        mobClose.addEventListener('click', () => mobMenu.style.transform = 'translateY(-110%)');

        /* mobile categories accordion */
        const mobCatBtn = document.getElementById('mobile-categories-btn');
        const mobCatList = document.getElementById('mobile-categories-list');
        const mobCatArrow = document.getElementById('mobile-categories-arrow');
        mobCatBtn.addEventListener('click', () => {
            const open = mobCatList.style.maxHeight && mobCatList.style.maxHeight !== '0px';
            mobCatList.style.maxHeight = open ? '0' : mobCatList.scrollHeight + 'px';
            mobCatArrow.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
        });
    });
</script>
