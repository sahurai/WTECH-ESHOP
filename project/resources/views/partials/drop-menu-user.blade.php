<a href="{{ route('basket.index') }}" class="block px-4 py-2 hover:bg-gray-100 hover:rounded-md">Basket</a>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 hover:rounded-md">
        Logout
    </button>
</form>
