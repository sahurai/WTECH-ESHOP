<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenreController extends Controller
{
    /**
     * Display a listing of all genres.
     *
     * @return View
     */
    public function index(): View
    {
        // Get all genres from the database
        $genres = Genre::all();

        // Return the 'genres.index' view with the list of genres
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
        // Validate incoming data from the create form
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        // Create a new genre record with the validated data
        Genre::query()->create($validatedData);

        // Redirect to the genres index page with a success message
        return redirect()->route('genres.index')->with('success', 'Genre created successfully.');
    }

    /**
     * Display the specified genre.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        // Find the genre by ID
        $genre = Genre::query()->find($id);

        // If the genre is not found, redirect back with an error message
        if (!$genre) {
            return redirect()->route('genres.index')->with('error', 'Genre not found.');
        }

        // Return the view to display the genre details
        return view('genres.show', compact('genre'));
    }

    /**
     * Show the form for editing the specified genre.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        // Find the genre by ID
        $genre = Genre::query()->find($id);

        // If the genre is not found, redirect back with an error message
        if (!$genre) {
            return redirect()->route('genres.index')->with('error', 'Genre not found.');
        }

        // Return the edit form view with the genre data
        return view('genres.edit', compact('genre'));
    }

    /**
     * Update the specified genre in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Find the genre by ID
        $genre = Genre::query()->find($id);

        // If the genre is not found, redirect with an error message
        if (!$genre) {
            return redirect()->route('genres.index')->with('error', 'Genre not found.');
        }

        // Validate incoming data from the edit form. Use 'unique' rule with the exception for current genre ID.
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:genres,name,' . $id,
            'description' => 'nullable|string',
        ]);

        // Update the genre record with the validated data
        $genre->update($validatedData);

        // Redirect to the genre's detail page with a success message
        return redirect()->route('genres.show', $genre->id)->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified genre from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Find the genre by ID
        $genre = Genre::query()->find($id);

        // If the genre is not found, redirect back with an error message
        if (!$genre) {
            return redirect()->route('genres.index')->with('error', 'Genre not found.');
        }

        // Delete the genre record from the database
        $genre->delete();

        // Redirect to the genres index page with a success message
        return redirect()->route('genres.index')->with('success', 'Genre deleted successfully.');
    }
}
