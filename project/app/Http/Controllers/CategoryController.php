<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     *
     * @return View
     */
    public function index(): View
    {
        // Get all categories from the database
        $categories = Category::all();

        // Return the 'categories.index' view with the list of categories
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new category
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data from the create form
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        // Create a new category record with the validated data
        Category::query()->create($validatedData);

        // Redirect to the categories index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        // Find the category by ID
        $category = Category::query()->find($id);

        // If the category is not found, redirect back with an error message
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        // Return the view to display the category details
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        // Find the category by ID
        $category = Category::query()->find($id);

        // If the category is not found, redirect back with an error message
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        // Return the edit form view with the category data
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Find the category by ID
        $category = Category::query()->find($id);

        // If the category is not found, redirect with an error message
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        // Validate incoming data from the edit form. Use 'unique' rule with the exception for current category ID.
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        // Update the category record with the validated data
        $category->update($validatedData);

        // Redirect to the category's detail page with a success message
        return redirect()->route('categories.show', $category->id)->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Find the category by ID
        $category = Category::query()->find($id);

        // If the category is not found, redirect back with an error message
        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        // Delete the category record from the database
        $category->delete();

        // Redirect to the categories index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
