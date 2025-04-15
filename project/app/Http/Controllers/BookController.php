<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of all books.
     *
     * @return View
     */
    public function index(): View
    {
        // Get all books from the database
        $books = Book::all();

        // Return the 'books.index' view with the list of books
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new book
        return view('books.create');
    }

    /**
     * Store a newly created book in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data from the create form
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'description'   => 'nullable|string',
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
            'cover_url'     => 'nullable|url',
        ]);

        // Create a new book record with the validated data
        $book = Book::query()->create($validatedData);

        // Sync categories and genres if provided in the request
        $categories = $request->input('categories', []); // Expecting an array of category IDs
        $genres = $request->input('genres', []);           // Expecting an array of genre IDs

        $book->categories()->sync($categories);
        $book->genres()->sync($genres);

        // Redirect to the index page with a success message
        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified book.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        // Find the book by ID
        $book = Book::query()->find($id);

        // If the book is not found, redirect back with an error message
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Return the view to display the book details
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        // Find the book by ID
        $book = Book::query()->find($id);

        // If the book is not found, redirect back with an error message
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Return the edit form view with the book data
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified book in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Find the book by ID
        $book = Book::query()->find($id);

        // If the book is not found, redirect with an error message
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Validate incoming data from the edit form. Use 'sometimes' for optional fields.
        $validatedData = $request->validate([
            'title'         => 'sometimes|required|string|max:255',
            'author'        => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string',
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
            'cover_url'     => 'nullable|url',
        ]);

        // Update the book record with the validated data
        $book->update($validatedData);

        // Sync categories and genres if provided in the request
        $categories = $request->input('categories', []);
        $genres = $request->input('genres', []);

        $book->categories()->sync($categories);
        $book->genres()->sync($genres);

        // Redirect to the book's detail page with a success message
        return redirect()->route('books.show', $book->id)->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Find the book by ID
        $book = Book::query()->find($id);

        // If the book is not found, redirect back with an error message
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Delete the book record from the database
        $book->delete();

        // Redirect to the books index page with a success message
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
