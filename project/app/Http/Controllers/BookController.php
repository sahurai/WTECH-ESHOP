<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookImage;
use App\Models\Category;
use Exception;
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
            $query->where('language', $request->input('language'));
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

        // Paginate results: 12 books per page
        $books = $query->paginate(12);

        // Return category view with books, admin flag, and category context
        return view('category', compact('books', 'isAdmin', 'category'));
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

    /**
     * Show the form for creating a new book (admin/moderator only).
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Store a newly created book along with its images.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate book data
        $validatedData = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric',
            'quantity'     => 'required|integer',
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

        // Execute within a transaction to ensure atomicity
        DB::transaction(function () use ($validatedData, $request) {
            // Create book record
            $book = Book::query()->create($validatedData);

            // Sync categories and genres
            $categories = $request->input('categories', []);
            $genres     = $request->input('genres', []);
            $book->categories()->sync($categories);
            $book->genres()->sync($genres);

            // Validate image URLs (at least 2 required)
            $images = $request->input('images', []);
            if (count($images) < 2) {
                // Throw exception to rollback
                throw new Exception('At least two images are required.');
            }

            // Save images with sort order
            foreach ($images as $index => $url) {
                BookImage::query()->create([
                    'book_id'   => $book->id,
                    'image_url' => $url,
                    'sort_order'=> $index,
                ]);
            }
        });

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Show the form for editing an existing book (admin/moderator only).
     */
    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified book along with its images.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        // Validate provided fields
        $validatedData = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'author'       => 'sometimes|required|string|max:255',
            'description'  => 'sometimes|required|string',
            'price'        => 'sometimes|required|numeric',
            'quantity'     => 'sometimes|required|integer',
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

        // Update book record
        $book->update($validatedData);

        // Sync categories and genres
        $book->categories()->sync($request->input('categories', []));
        $book->genres()->sync($request->input('genres', []));

        // Update images if provided
        if ($request->has('images')) {
            $images = $request->input('images', []);
            if (count($images) < 2) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'At least two images are required.');
            }

            // Delete old images and save new ones
            $book->images()->delete();
            foreach ($images as $index => $url) {
                BookImage::query()->create([
                    'book_id'   => $book->id,
                    'image_url' => $url,
                    'sort_order'=> $index,
                ]);
            }
        }

        return redirect()->route('books.show', $book)
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage (admin/moderator only).
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
