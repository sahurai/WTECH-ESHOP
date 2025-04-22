<!-- Filters section -->
<aside class="bg-white-2 p-4 w-full md:w-1/5 rounded-lg shadow-md border border-white">
    <h2 class="text-lg font-semibold text-true-dark">Filters</h2>
    <form method="GET" action="{{ route('books.index') }}">
        @foreach (['sort', 'search', 'category_id'] as $param)
            @if (request($param))
                <input name="{{ $param }}" type="hidden" value="{{ request($param) }}">
            @endif
        @endforeach
        <!-- Language filter example -->
        <section class="mb-1">
            <h3 class="font-medium text-true-dark">Language</h3>
            <ul class="space-y-1">
                @foreach ($availableLanguages as $lang)
                    <li>
                        <label class="inline-flex items-center space-x-2 text-blue">
                            <input type="checkbox" class="form-checkbox" name="language[]" value="{{ $lang }}"
                                {{ in_array($lang, request()->input('language', [])) ? 'checked' : '' }}>
                            <span>{{ $lang }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </section>
        <!-- Author filter example -->
        <section class="mb-1">

            <h3 class="font-medium">Author</h3>
            <ul class="space-y-1">
                @foreach ($availableAuthors as $author)
                    <li>
                        <label class="inline-flex items-center space-x-2 text-blue">
                            <input type="checkbox" class="form-checkbox" name="author[]" value="{{ $author }}"
                                {{ in_array($author, request()->input('author', [])) ? 'checked' : '' }}>
                            <span>{{ $author }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </section>
        <!-- Price filter example -->
        <section class="mb-1">
            <h3 class="font-medium text-true-dark">Price</h3>
            <div class="flex items-center space-x-2">
                <input type="number" name="price_min" placeholder="From"
                    class="w-20 rounded border border-gray-300 p-1" value="{{ request('price_min') }}" />
                <span>-</span>
                <input type="number" name="price_max" placeholder="To" class="w-20 rounded border border-gray-300 p-1"
                    value="{{ request('price_max') }}" />
            </div>
        </section>
        <!-- Submit button -->
        <div class="mt-3">
            <button type="submit"
                class="w-full bg-red-800 hover:bg-red-400 text-white font-semibold py-2 px-4 rounded">
                Apply Filters
            </button>
        </div>
    </form>
</aside>
