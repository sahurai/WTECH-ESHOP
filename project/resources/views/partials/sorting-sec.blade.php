<!-- Sorting section with radio buttons -->
<section class="bg-white-2 p-2 rounded-lg shadow-md border border-white">
    <form method="GET"
        action="{{ isset($category) ? route('category.books', ['id' => $category->id]) : route('books.search') }}">

        @foreach (request()->except('sort') as $key => $value)
            @if (is_array($value))
                @foreach ($value as $v)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <div class="flex flex-row items-center">
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="new" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort', 'new') === 'new' ? 'checked' : '' }}>
                    <span class="ml-2">New</span>
                </label>
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="title_asc" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort') === 'title_asc' ? 'checked' : '' }}>
                    <span class="ml-2">Title A-Z</span>
                </label>
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="title_desc" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort') === 'title_desc' ? 'checked' : '' }}>
                    <span class="ml-2">Title Z-A</span>
                </label>
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="price_desc" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort') === 'price_desc' ? 'checked' : '' }}>
                    <span class="ml-2">Most expensive</span>
                </label>
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="price_asc" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort') === 'price_asc' ? 'checked' : '' }}>
                    <span class="ml-2">Most cheap</span>
                </label>

            </div>
        </div>
    </form>
</section>
