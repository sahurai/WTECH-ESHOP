<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookImage;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Apply middleware to protect actions that require admin or moderator role.
     */
    public function __construct()
    {
        // Only admins and moderators can create, store, edit, update, or destroy books.
        $this->middleware('check.role')->only([
            'create', 'store', 'edit', 'update', 'destroy'
        ]);
    }

    /**
     * Display a listing of books with filtering, sorting, and pagination.
     */
    public function index(Request $request): View
    {
        // Check if the current user is admin or moderator
        $isAdmin = auth()->check() && auth()->user()
                ->roles()->whereIn('name', ['admin', 'moderator'])->exists();

        // Check if this request is for the homepage
        $isHomepage = $request->is('/');

        if ($isHomepage) {
            // Show a random selection of bestsellers
            $bestsellers = Book::with('images')->inRandomOrder()->take(10)->get();

            // Show newest books by release year
            $new = Book::with('images')->orderBy('release_year', 'desc')->take(10)->get();

            // Return homepage view with admin flag
            return view('homepage', compact('bestsellers', 'new', 'isAdmin'));
        }

        $query = Book::query();
        $category = null;

        // Filter by category if provided
        if ($request->filled('category_id')) {
            $categoryId = $request->input('category_id');
            $category = Category::query()->find($categoryId);
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Filter by price range if provided
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Filter by pages count range if provided
        if ($request->filled('pages_count_min')) {
            $query->where('pages_count', '>=', $request->input('pages_count_min'));
        }
        if ($request->filled('pages_count_max')) {
            $query->where('pages_count', '<=', $request->input('pages_count_max'));
        }

        // Filter by language if provided
        if ($request->filled('language')) {
            $query->whereIn('language', $request->input('language'));
        }
        if ($request->filled('author')) {
            $query->whereIn('author', $request->input('author'));
        }

        // Full-text search on title, author, and description (case-insensitive)
        if ($request->filled('search')) {
            $search = mb_strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(author) LIKE ?', ["%$search%"]);
            });
        }

        // Define mapping for sort options to column and direction
        $sortMap = [
            'newest'        => ['release_year', 'desc'],
            'oldest'        => ['release_year', 'asc'],
            'title_asc'     => ['title', 'asc'],
            'title_desc'    => ['title', 'desc'],
            'price_asc'     => ['price', 'asc'],
            'price_desc'    => ['price', 'desc'],
        ];

        // Determine sort option, default to title ascending
        $sortOption = $request->input('sort', 'title_asc');
        if (!array_key_exists($sortOption, $sortMap)) {
            $sortOption = 'title_asc';
        }

        // Apply sorting based on mapping
        [$sortBy, $order] = $sortMap[$sortOption];
        $query->orderBy($sortBy, $order);

        $availableLanguages = Book::select('language')
        ->distinct()
        ->whereNotNull('language')
        ->pluck('language');

        $availableAuthors = Book::select('author')
        ->distinct()
        ->whereNotNull('author')
        ->pluck('author');

        // Paginate results: 12 books per page
        $books = $query->paginate(12);

        // Return category view with books, admin flag, and category context
        return view('category', compact('books', 'isAdmin', 'category','availableLanguages','availableAuthors'));
    }

    /**
     * Display details of a single book.
     */
    public function show(Book $book): View
    {
        // Check if the current user is admin or moderator
        $isAdmin = auth()->check() && auth()->user()
                ->roles()->whereIn('name', ['admin', 'moderator'])->exists();

        // Eager load relationships
        $book->load(['categories', 'genres', 'images']);

        // Recommend other books in the same categories
        $recommends = Book::with('images')
            ->whereHas('categories', function ($q) use ($book) {
                $q->whereIn('categories.id', $book->categories->pluck('id'));
            })
            ->where('books.id', '!=', $book->id)
            ->take(10)
            ->get();

        // Return product page view
        return view('product-page', compact('book', 'isAdmin', 'recommends'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $genres     = Genre::all();
        return view('book-page', compact('categories','genres'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate all fields and multiple images
        $validated = $request->validate([
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

        DB::transaction(function() use ($validated, $request) {
            // 1) create book record
            $book = Book::create([
                'title'        => $validated['title'],
                'author'       => $validated['author'],
                'description'  => $validated['description'],
                'price'        => $validated['price'],
                'quantity'     => $validated['quantity'],
                'pages_count'  => $validated['pages_count'] ?? null,
                'release_year' => $validated['release_year'] ?? null,
                'language'     => $validated['language'] ?? null,
                'format'       => $validated['format'] ?? null,
                'publisher'    => $validated['publisher'] ?? null,
                'isbn'         => $validated['isbn'] ?? null,
                'edition'      => $validated['edition'] ?? null,
                'dimensions'   => $validated['dimensions'] ?? null,
                'weight'       => $validated['weight'] ?? null,
            ]);

            // 2) sync genres & categories
            $book->genres()->sync($validated['genres']);
            $book->categories()->sync($validated['categories']);

            // 3) store each uploaded image
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('book-images','public');
                BookImage::create([
                    'book_id'    => $book->id,
                    'image_url'  => $path,
                    'sort_order' => $index,
                    'is_cover'   => $index === 0,
                ]);
            }
        });

        return redirect()->route('books.index')
            ->with('success','Book created successfully.');
    }

    public function edit(Book $book): View
    {
        // eager-load relations including images
        $book->load(['genres','categories','images']);

        $categories = Category::all();
        $genres     = Genre::all();
        return view('book-page', compact('book','categories','genres'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        // Validate all fields; images optional
        $validated = $request->validate([
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

        // 1) update book fields
        $book->update([
            'title'        => $validated['title'],
            'author'       => $validated['author'],
            'description'  => $validated['description'],
            'price'        => $validated['price'],
            'quantity'     => $validated['quantity'],
            'pages_count'  => $validated['pages_count'] ?? null,
            'release_year' => $validated['release_year'] ?? null,
            'language'     => $validated['language'] ?? null,
            'format'       => $validated['format'] ?? null,
            'publisher'    => $validated['publisher'] ?? null,
            'isbn'         => $validated['isbn'] ?? null,
            'edition'      => $validated['edition'] ?? null,
            'dimensions'   => $validated['dimensions'] ?? null,
            'weight'       => $validated['weight'] ?? null,
        ]);

        // 2) sync genres & categories
        $book->genres()->sync($validated['genres']);
        $book->categories()->sync($validated['categories']);

        // 3) if new images uploaded, replace old
        if ($request->hasFile('images')) {
            $book->images()->delete();
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('book-images','public');
                BookImage::create([
                    'book_id'    => $book->id,
                    'image_url'  => $path,
                    'sort_order' => $index,
                    'is_cover'   => $index === 0,
                ]);
            }
        }

        return redirect()->route('books.show', $book)
            ->with('success','Book updated successfully.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();
        return redirect()->route('books.index')
            ->with('success','Book deleted successfully.');
    }
}
