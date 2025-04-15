<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     *
     * @return View
     */
    public function index(): View
    {
        // Get all users from the database
        $users = User::all();

        // Return the 'users.index' view with the list of users
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View
     */
    public function create(): View
    {
        // Return the view to create a new user
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate incoming data from the create form
        $validatedData = $request->validate([
            'username'     => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password_hash'=> 'required|string|min:6',
            'address_line' => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:100',
            'state'        => 'nullable|string|max:100',
            'postal_code'  => 'nullable|string|max:20',
            'country'      => 'nullable|string|max:100',
        ]);

        // Hash the password before storing it in the database
        $validatedData['password_hash'] = Hash::make($validatedData['password_hash']);

        // Create a new user record with the validated data
        User::query()->create($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        // Find the user by ID
        $user = User::query()->find($id);

        // If the user is not found, redirect back with an error message
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Return the view to display the user details
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        // Find the user by ID
        $user = User::query()->find($id);

        // If user not found, redirect back with an error message
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Return the edit form view with the user data
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // Find the user by ID
        $user = User::query()->find($id);

        // If user not found, redirect with an error message
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Validate incoming data from the edit form. Use 'sometimes' for optional fields.
        $validatedData = $request->validate([
            'username'     => 'sometimes|required|string|max:255',
            'email'        => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password_hash'=> 'sometimes|required|string|min:6',
            'address_line' => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:100',
            'state'        => 'nullable|string|max:100',
            'postal_code'  => 'nullable|string|max:20',
            'country'      => 'nullable|string|max:100',
        ]);

        // If a new password is provided, hash it before updating
        if (isset($validatedData['password_hash'])) {
            $validatedData['password_hash'] = Hash::make($validatedData['password_hash']);
        }

        // Update the user record with the validated data
        $user->update($validatedData);

        // Redirect to the user's detail page with a success message
        return redirect()->route('users.show', $user->id)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Find the user by ID
        $user = User::query()->find($id);

        // If user not found, redirect back with an error message
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Delete the user record from the database
        $user->delete();

        // Redirect to the users index page with a success message
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
