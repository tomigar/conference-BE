<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConferenceController extends BaseController
{
    /**
     * Display a listing of the conferences.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $conferences = Conference::with('editors')->orderBy('year', 'desc')->get();
        return $this->sendResponse(ConferenceResource::collection($conferences));
    }

    /**
     * Store a newly created conference in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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

        $conference = Conference::create($validated);

        return $this->sendResponse(
            new ConferenceResource($conference),
            'Conference created successfully',
            201
        );
    }

    /**
     * Display the specified conference.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Conference $conference)
    {
        $conference->load('editors');
        return $this->sendResponse(new ConferenceResource($conference));
    }

    /**
     * Update the specified conference in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\JsonResponse
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

        return $this->sendResponse(
            new ConferenceResource($conference),
            'Conference updated successfully'
        );
    }

    /**
     * Remove the specified conference from storage.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Conference $conference)
    {
        $conference->delete();

        return $this->sendResponse(null, 'Conference deleted successfully');
    }
}
