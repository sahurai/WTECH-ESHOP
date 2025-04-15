<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenreController extends Controller
{
    /**
     * Apply middleware to protect actions that require admin or moderator role.
     */
    public function __construct()
    {
        // Apply the 'check.role' middleware only to the specified methods.
        $this->middleware('check.role')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of all genres.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve all genres from the database
        $genres = Genre::all();

        // Return the 'genres.index' view along with the genres data
        return view('genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new genre.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new genre
        return view('genres.create');
    }

    /**
     * Store a newly created genre in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        // Create a new genre record using the validated data
        Genre::query()->create($validatedData);

        // Redirect to the genres index page with a success message
        return redirect()->route('genres.index')
            ->with('success', 'Genre created successfully.');
    }

    /**
     * Display the specified genre.
     *
     * @param Genre $genre
     * @return View
     */
    public function show(Genre $genre): View
    {
        // Return the view to display the genre details
        return view('genres.show', compact('genre'));
    }

    /**
     * Show the form for editing the specified genre.
     *
     * @param Genre $genre
     * @return View
     */
    public function edit(Genre $genre): View
    {
        // Return the view to edit the specified genre
        return view('genres.edit', compact('genre'));
    }

    /**
     * Update the specified genre in storage.
     *
     * @param Request $request
     * @param Genre $genre
     * @return RedirectResponse
     */
    public function update(Request $request, Genre $genre): RedirectResponse
    {
        // Validate the request data. The 'unique' rule is applied with an exception for the current genre.
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
        ]);

        // Update the genre record with the validated data
        $genre->update($validatedData);

        // Redirect to the genre detail page with a success message
        return redirect()->route('genres.show', $genre->id)
            ->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified genre from storage.
     *
     * @param Genre $genre
     * @return RedirectResponse
     */
    public function destroy(Genre $genre): RedirectResponse
    {
        // Delete the genre record from the database
        $genre->delete();

        // Redirect to the genres index page with a success message
        return redirect()->route('genres.index')
            ->with('success', 'Genre deleted successfully.');
    }
}
