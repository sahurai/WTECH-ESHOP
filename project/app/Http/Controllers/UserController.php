<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Constructor
     *
     * Apply the "check.role" middleware only to edit, update, and destroy actions
     * so that only admin or moderator users can perform these actions.
     */
    public function __construct()
    {
        $this->middleware('check.role')->only(['index', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of all users.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve all users from the database
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * This method validates incoming request data, creates a user,
     * and forcefully assigns the default "user" role.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate request data
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

        // Hash the password before saving it to the database
        $validatedData['password_hash'] = Hash::make($validatedData['password_hash']);

        // Create the new user
        $user = User::query()->create($validatedData);

        // Force default role assignment (ignoring any roles from the request)
        $defaultRole = Role::query()->where('name', 'user')->first();
        if ($defaultRole) {
            $user->roles()->sync([$defaultRole->id]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     * Only admins or moderators can access this.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     * Only admins or moderators are allowed.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Validate the incoming request data.
        $validatedData = $request->validate([
            'username'     => 'sometimes|required|string|max:255',
            'email'        => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password_hash'=> 'sometimes|required|string|min:6',
            'address_line' => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:100',
            'state'        => 'nullable|string|max:100',
            'postal_code'  => 'nullable|string|max:20',
            'country'      => 'nullable|string|max:100',
        ]);

        // Hash the new password if provided.
        if (isset($validatedData['password_hash'])) {
            $validatedData['password_hash'] = Hash::make($validatedData['password_hash']);
        }

        $user->update($validatedData);

        return redirect()->route('users.show', $user->id)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     * Only admins or moderators are allowed.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
