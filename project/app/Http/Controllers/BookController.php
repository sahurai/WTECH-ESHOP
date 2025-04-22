<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookImage;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function __construct()
    {
        // Protect admin/moderator actions
        $this->middleware('check.role')->only([
            'create', 'store', 'edit', 'update', 'destroy'
        ]);
    }

    /**
     * Display a listing of books.
     */
    public function index(Request $request): View
    {
        $isAdmin = auth()->check() && auth()->user()
                ->roles()->whereIn('name', ['admin', 'moderator'])->exists();

        $isHomepage = $request->is('/');
        if ($isHomepage) {
            $bestsellers = Book::with('images')->inRandomOrder()->take(10)->get();
            $newest = Book::with('images')->orderBy('release_year', 'desc')->take(10)->get();
            return view('homepage', compact('bestsellers', 'newest', 'isAdmin'));
        }
    
        $query = Book::query();
        $category = null;

        // Filters
        if ($request->filled('category_id')) {
            $categoryId = $request->input('category_id');
            $category = Category::find($categoryId);
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }
        if ($request->filled('pages_count_min')) {
            $query->where('pages_count', '>=', $request->input('pages_count_min'));
        }
        if ($request->filled('pages_count_max')) {
            $query->where('pages_count', '<=', $request->input('pages_count_max'));
        }
        if ($request->filled('language')) {
            $query->whereIn('language', $request->input('language'));
        }
        if ($request->filled('author')) {
            $query->whereIn('author', $request->input('author'));
        }

        // Search
        if ($request->filled('search')) {
            $search = mb_strtolower($request->input('search'));
            $query->where(fn($q) =>
            $q->whereRaw('LOWER(title) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(author) LIKE ?', ["%$search%"])
            );
        }

        // Sorting
        $sortMap = [
            'newest'    => ['release_year', 'desc'],
            'oldest'    => ['release_year', 'asc'],
            'title_asc' => ['title', 'asc'],
            'title_desc'=> ['title', 'desc'],
            'price_asc' => ['price', 'asc'],
            'price_desc'=> ['price', 'desc'],
        ];
        $sortOption = $request->input('sort', 'title_asc');
        if (!isset($sortMap[$sortOption])) {
            $sortOption = 'title_asc';
        }
        [$sortBy, $order] = $sortMap[$sortOption];
        $query->orderBy($sortBy, $order);

        $availableLanguages = Book::select('language')->distinct()->whereNotNull('language')->pluck('language');
        $availableAuthors   = Book::select('author')->distinct()->whereNotNull('author')->pluck('author');

        $books = $query->paginate(12);

        return view('category', compact('books', 'isAdmin', 'category', 'availableLanguages', 'availableAuthors'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = Category::all();
        $genres     = Genre::all();
        return view('add-book-page', compact('categories', 'genres'));
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric',
            'quantity'     => 'required|integer',
            'images'       => 'required|array|min:2',
            'images.*'     => 'image|max:2048',
            'genres'       => 'required|array|min:1',
            'genres.*'     => 'exists:genres,id',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'pages_count'  => 'nullable|integer',
            'release_year' => 'nullable|integer',
            'language'     => 'nullable|string|max:50',
            'format'       => 'nullable|string|max:50',
            'publisher'    => 'nullable|string|max:100',
            'isbn'         => 'nullable|string|max:20',
            'edition'      => 'nullable|string|max:50',
            'dimensions'   => 'nullable|string|max:100',
            'weight'       => 'nullable|numeric',
        ]);

        DB::transaction(function() use ($data, $request) {
            $book = Book::create($data);
            $book->genres()->sync($data['genres']);
            $book->categories()->sync($data['categories']);

            $baseSlug = Str::slug("{$book->title}-{$book->author}");
            foreach ($request->file('images') as $i => $file) {
                $ext = $file->extension();
                $filename = "{$baseSlug}-" . ($i + 1) . ".{$ext}";
                $path = $file->storeAs('book-images', $filename, 'public');
                BookImage::create([
                    'book_id'   => $book->id,
                    'image_url' => $path,
                    'sort_order'=> $i,
                ]);
            }
        });

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        $isAdmin = auth()->check() && auth()->user()
                ->roles()->whereIn('name', ['admin', 'moderator'])->exists();

        $book->load(['categories', 'genres', 'images']);

        $recommends = Book::with('images')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', $book->categories->pluck('id')))
            ->where('books.id', '!=', $book->id)
            ->take(10)
            ->get();

        return view('book-page', compact('book', 'isAdmin', 'recommends'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book): View
    {
        $book->load(['genres', 'categories', 'images']);
        $categories = Category::all();
        $genres     = Genre::all();
        return view('edit-book-page', compact('book','categories','genres'));
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric',
            'quantity'     => 'required|integer',
            'images'       => 'sometimes|array|min:2',
            'images.*'     => 'image|max:2048',
            'genres'       => 'required|array|min:1',
            'genres.*'     => 'exists:genres,id',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'pages_count'  => 'nullable|integer',
            'release_year' => 'nullable|integer',
            'language'     => 'nullable|string|max:50',
            'format'       => 'nullable|string|max:50',
            'publisher'    => 'nullable|string|max:100',
            'isbn'         => 'nullable|string|max:20',
            'edition'      => 'nullable|string|max:50',
            'dimensions'   => 'nullable|string|max:100',
            'weight'       => 'nullable|numeric',
        ]);

        $book->update($data);
        $book->genres()->sync($data['genres']);
        $book->categories()->sync($data['categories']);

        if ($request->hasFile('images')) {
            $book->images()->delete();

            $baseSlug = Str::slug("{$book->title}-{$book->author}");
            foreach ($request->file('images') as $i => $file) {
                $ext = $file->extension();
                $filename = "{$baseSlug}-" . ($i + 1) . ".{$ext}";
                $path = $file->storeAs('book-images', $filename, 'public');
                BookImage::create([
                    'book_id'   => $book->id,
                    'image_url' => $path,
                    'sort_order'=> $i,
                ]);
            }
        }

        return redirect()->route('books.show', $book)->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
