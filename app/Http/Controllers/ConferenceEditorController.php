<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\UserResource;

class ConferenceEditorController extends BaseController
{
    /**
     * Get editors for a specific conference.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEditors(Conference $conference)
    {
        $editors = $conference->editors()->orderBy('name')->get();

        return $this->sendResponse(UserResource::collection($editors));
    }

    /**
     * Get available editors that can be assigned to a conference.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableEditors(Conference $conference)
    {
        $assignedEditorIds = $conference->editors()->pluck('users.id');

        $availableEditors = User::where('role', User::ROLE_EDITOR)
            ->whereNotIn('id', $assignedEditorIds)
            ->orderBy('name')
            ->get();

        return $this->sendResponse(UserResource::collection($availableEditors));
    }

    /**
     * Assign an editor to a conference.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignEditor(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'editor_id' => ['required', 'exists:users,id'],
        ]);

        // Check if the user is an editor
        $editor = User::findOrFail($validated['editor_id']);
        if ($editor->role !== User::ROLE_EDITOR) {
            return $this->sendError('Only editors can be assigned to conferences.');
        }

        // Check if the editor is already assigned
        if ($conference->editors()->where('user_id', $editor->id)->exists()) {
            return $this->sendError('This editor is already assigned to this conference.');
        }

        // Assign the editor to the conference
        $conference->editors()->attach($editor->id);

        return $this->sendResponse(
            new UserResource($editor),
            'Editor assigned to conference successfully.',
            201
        );
    }

    /**
     * Remove an editor from a conference.
     *
     * @param  \App\Models\Conference  $conference
     * @param  \App\Models\User  $editor
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeEditor(Conference $conference, User $editor)
    {
        // Check if the editor is actually assigned to this conference
        if (!$conference->editors()->where('user_id', $editor->id)->exists()) {
            return $this->sendError('This editor is not assigned to this conference.');
        }

        $conference->editors()->detach($editor->id);

        return $this->sendResponse(null, 'Editor removed from conference successfully.');
    }
}
