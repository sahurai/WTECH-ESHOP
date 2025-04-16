<!-- Sorting section with radio buttons -->
<section class="bg-white-2 p-2 rounded-lg shadow-md border border-white">
    <form method="GET" action="{{ route('category.books', ['id' => $category->id]) }}">

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
                    <input type="radio" name="sort" value="bestsellers" class="form-radio text-dark-red"
                        onchange="this.form.submit()"
                        {{ request('sort', 'bestsellers') === 'bestsellers' ? 'checked' : '' }}>
                    <span class="ml-2">Bestsellers</span>
                </label>
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="most_expensive" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort') === 'most_expensive' ? 'checked' : '' }}>
                    <span class="ml-2">Most expensive</span>
                </label>
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="most_cheap" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort') === 'most_cheap' ? 'checked' : '' }}>
                    <span class="ml-2">Most cheap</span>
                </label>
                <label class="inline-flex items-center text-blue">
                    <input type="radio" name="sort" value="new" class="form-radio text-dark-red"
                        onchange="this.form.submit()" {{ request('sort') === 'new' ? 'checked' : '' }}>
                    <span class="ml-2">New</span>
                </label>
            </div>
        </div>
    </form>
</section>
