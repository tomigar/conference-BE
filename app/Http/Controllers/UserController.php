<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $editors = User::where('role', User::ROLE_EDITOR)->orderBy('name')->get();
        $admins = User::where('role', User::ROLE_ADMIN)->orderBy('name')->get();

        return view('users.index', compact('editors', 'admins'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(Request $request)
    {
        $role = $request->query('role', User::ROLE_EDITOR);
        return view('users.create', compact('role'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_EDITOR])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        $roleType = $validated['role'] === User::ROLE_ADMIN ? 'administrator' : 'editor';

        return redirect()->route('users.index')
            ->with('success', "New {$roleType} added successfully.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $roleType = $user->role === User::ROLE_ADMIN ? 'administrator' : 'editor';

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "{$roleType} removed successfully.");
    }
}
