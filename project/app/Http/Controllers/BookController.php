<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Apply middleware to protect actions that require admin or moderator role.
     */
    public function __construct()
    {
        // The "check.role" middleware is applied only to create, store, edit, update, and destroy actions.
        $this->middleware('check.role')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of books with filtering, sorting, and pagination.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Book::query();

        // Filter by category if provided (e.g. ?category_id=3)
        if ($request->filled('category_id')) {
            $categoryId = $request->input('category_id');
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('id', $categoryId);
            });
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Filter by pages count range
        if ($request->filled('pages_count_min')) {
            $query->where('pages_count', '>=', $request->input('pages_count_min'));
        }
        if ($request->filled('pages_count_max')) {
            $query->where('pages_count', '<=', $request->input('pages_count_max'));
        }

        // Filter by language
        if ($request->filled('language')) {
            $query->where('language', $request->input('language'));
        }

        // Full-text search on title, author, and description
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('author', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        // Allowed columns for sorting: title and price
        $allowedSortColumns = ['title', 'price'];

        // Determine sorting parameters; default sort is by title (ascending)
        $sortBy = $request->input('sort_by', 'title');
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'title';
        }
        $order = $request->input('order', 'asc');
        $query->orderBy($sortBy, $order);

        // Paginate results (e.g., 12 books per page)
        $books = $query->paginate(12);

        return view('books.index', compact('books'));
    }

    /**
     * Display details of a single book.
     *
     * @param Book $book
     * @return View
     */
    public function show(Book $book): View
    {
        // Eager load the relationships: categories, genres, and images
        $isAdmin = false;
        $book->load(['categories', 'genres', 'images']);
        $recommends= Book::with('images')->whereHas('categories',function($query) use($book){
            $query->whereIn('categories.id',$book->categories->pluck('id'));
        })->where('books.id','!=',$book->id)->take(10)->get();
        return view('product-page', compact('book','isAdmin','recommends'));
    }

    /**
     * Show the form for creating a new book.
     * Only admins or moderators are allowed.
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Store a newly created book along with its images.
     * Only admins or moderators are allowed.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate book data
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'description'   => 'required|string',
            'price'         => 'required|numeric',
            'quantity'      => 'required|integer',
            'pages_count'   => 'nullable|integer',
            'release_year'  => 'nullable|integer',
            'language'      => 'nullable|string|max:50',
            'format'        => 'nullable|string|max:50',
            'publisher'     => 'nullable|string|max:100',
            'isbn'          => 'nullable|string|max:20',
            'edition'       => 'nullable|string|max:50',
            'dimensions'    => 'nullable|string|max:100',
            'weight'        => 'nullable|numeric',
        ]);

        $book = Book::query()->create($validatedData);

        // Sync categories and genres if provided (expecting arrays of IDs)
        $categories = $request->input('categories', []);
        $genres = $request->input('genres', []);
        $book->categories()->sync($categories);
        $book->genres()->sync($genres);

        // Validate and store book images (at least 2 images required)
        $images = $request->input('images', []); // expecting an array of image URLs
        if (count($images) < 2) {
            // Delete the created book if the images requirement is not met
            $book->delete();
            return redirect()->back()->withInput()->with('error', 'At least two images are required.');
        }

        foreach ($images as $index => $imageUrl) {
            BookImage::query()->create([
                'book_id'    => $book->id,
                'image_url'  => $imageUrl,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Show the form for editing an existing book.
     * Only admins or moderators are allowed.
     *
     * @param Book $book
     * @return View
     */
    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified book along with its images.
     * Only admins or moderators are allowed.
     *
     * @param Request $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        // Validate book data (using "sometimes" for optional update fields)
        $validatedData = $request->validate([
            'title'         => 'sometimes|required|string|max:255',
            'author'        => 'sometimes|required|string|max:255',
            'description'   => 'sometimes|required|string',
            'price'         => 'sometimes|required|numeric',
            'quantity'      => 'sometimes|required|integer',
            'pages_count'   => 'nullable|integer',
            'release_year'  => 'nullable|integer',
            'language'      => 'nullable|string|max:50',
            'format'        => 'nullable|string|max:50',
            'publisher'     => 'nullable|string|max:100',
            'isbn'          => 'nullable|string|max:20',
            'edition'       => 'nullable|string|max:50',
            'dimensions'    => 'nullable|string|max:100',
            'weight'        => 'nullable|numeric',
        ]);

        $book->update($validatedData);

        // Sync categories and genres if provided
        $categories = $request->input('categories', []);
        $genres = $request->input('genres', []);
        $book->categories()->sync($categories);
        $book->genres()->sync($genres);

        // Optionally update images if provided
        if ($request->has('images')) {
            $images = $request->input('images', []);
            if (count($images) < 2) {
                return redirect()->back()->withInput()->with('error', 'At least two images are required.');
            }
            // Delete existing images and add new ones
            $book->images()->delete();
            foreach ($images as $index => $imageUrl) {
                BookImage::query()->create([
                    'book_id'    => $book->id,
                    'image_url'  => $imageUrl,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('books.show', $book->id)
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     * Only admins or moderators are allowed.
     *
     * @param Book $book
     * @return RedirectResponse
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }

    public function homepage(): View
    {
        $bestsellers=Book::with('images')->inRandomOrder()->take(10)->get();
        $new=Book::with('images')->orderBy('release_year','desc')->take(10)->get();
        return view('homepage',compact('bestsellers','new'));
    }
}
