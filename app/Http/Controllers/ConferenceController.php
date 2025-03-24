<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConferenceController extends Controller
{
    /**
     * Display a listing of the conferences.
     */
    public function index()
    {
        $conferences = Conference::orderBy('year', 'desc')->get();
        return view('conferences.index', compact('conferences'));
    }

    /**
     * Show the form for creating a new conference.
     */
    public function create()
    {
        return view('conferences.create');
    }

    /**
     * Store a newly created conference in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'unique:conferences'],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        Conference::create($validated);

        return redirect()->route('conferences.index')
            ->with('success', 'Conference year added successfully.');
    }

    /**
     * Show the form for editing the specified conference.
     */
    public function edit(Conference $conference)
    {
        return view('conferences.edit', compact('conference'));
    }

    /**
     * Update the specified conference in storage.
     */
    public function update(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', Rule::unique('conferences')->ignore($conference->id)],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $conference->update($validated);

        return redirect()->route('conferences.index')
            ->with('success', 'Conference updated successfully.');
    }

    /**
     * Remove the specified conference from storage.
     */
    public function destroy(Conference $conference)
    {
        $conference->delete();

        return redirect()->route('conferences.index')
            ->with('success', 'Conference year deleted successfully.');
    }
}
