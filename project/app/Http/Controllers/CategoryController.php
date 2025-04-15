<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Apply route middleware to protect administrative actions.
     */
    public function __construct()
    {
        $this->middleware('check.role')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of all categories.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve all categories from the database
        $categories = Category::all();

        // Return the 'categories.index' view along with the categories data
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
        // Validate the incoming data from the create form
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        // Create a new category using the validated data
        Category::query()->create($validatedData);

        // Redirect to the categories index page with a success message
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     *
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        // Return the view to display the category details
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        // Return the edit form view with the category data
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param Request  $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        // Validate the incoming data from the edit form.
        $validatedData = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Update the category with the validated data
        $category->update($validatedData);

        // Redirect to the category's detail page with a success message
        return redirect()->route('categories.show', $category->id)
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Delete the category record from the database
        $category->delete();

        // Redirect to the categories index page with a success message
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
