<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Http\Request;

class ConferenceEditorController extends Controller
{
    /**
     * Show the editors for a specific conference.
     */
    public function index(Conference $conference)
    {
        $editors = $conference->editors()->orderBy('name')->get();
        $availableEditors = User::where('role', User::ROLE_EDITOR)
            ->whereNotIn('id', $editors->pluck('id'))
            ->orderBy('name')
            ->get();

        return view('conferences.editors.index', compact('conference', 'editors', 'availableEditors'));
    }

    /**
     * Assign an editor to a conference.
     */
    public function store(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'editor_id' => ['required', 'exists:users,id'],
        ]);

        $editor = User::findOrFail($validated['editor_id']);
        if ($editor->role !== User::ROLE_EDITOR) {
            return redirect()->route('conferences.editors.index', $conference)
                ->with('error', 'Only editors can be assigned to conferences.');
        }

        if ($conference->editors()->where('user_id', $editor->id)->exists()) {
            return redirect()->route('conferences.editors.index', $conference)
                ->with('error', 'This editor is already assigned to this conference.');
        }

        // Assign editor
        $conference->editors()->attach($editor->id);

        return redirect()->route('conferences.editors.index', $conference)
            ->with('success', 'Editor assigned to conference successfully.');
    }

    /**
     * Remove an editor from a conference.
     */
    public function destroy(Conference $conference, User $editor)
    {
        $conference->editors()->detach($editor->id);

        return redirect()->route('conferences.editors.index', $conference)
            ->with('success', 'Editor removed from conference successfully.');
    }
}
