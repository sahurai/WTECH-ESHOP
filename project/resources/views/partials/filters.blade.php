<!-- Filters section -->
<aside class="bg-white-2 p-4 w-full md:w-1/5 rounded-lg shadow-md border border-white">
    <h2 class="text-lg font-semibold text-true-dark">Filters</h2>
    <form method="GET" action="{{ route('category.books', ['id' => $category->id]) }}">
        @if (request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif

        <!-- Language filter example -->
        <section class="mb-1">
            <h3 class="font-medium text-true-dark">Language</h3>
            <ul class="space-y-1">
                @foreach (['English', 'Spanish', 'French'] as $lang)
                    <li>
                        <label class="inline-flex items-center space-x-2 text-blue">
                            <input type="checkbox" class="form-checkbox" name="language[]" value="{{ $lang }}"
                                onchange="this.form.submit()"
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
                @foreach (['Dostoevsky', 'Gogol', 'Pushkin'] as $author)
                    <li>
                        <label class="inline-flex items-center space-x-2 text-blue">
                            <input type="checkbox" class="form-checkbox" name="author[]" value="{{ $author }}"
                                onchange="this.form.submit()"
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
                    class="w-20 rounded border border-gray-300 p-1" value="{{ request('price_min') }}"
                    onchange="this.form.submit()" />
                <span>-</span>
                <input type="number" name="price_max" placeholder="To" class="w-20 rounded border border-gray-300 p-1"
                    value="{{ request('price_max') }}" onchange="this.form.submit()" />
            </div>
        </section>
    </form>
</aside>
