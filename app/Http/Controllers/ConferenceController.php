<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConferenceController extends Controller
{
    /**
     * Display a listing of the conferences.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $conferences = Conference::with('editors')->orderBy('year', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => ConferenceResource::collection($conferences)
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Conference created successfully',
            'data' => new ConferenceResource($conference)
        ], 201);
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
        return response()->json([
            'success' => true,
            'data' => new ConferenceResource($conference)
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Conference updated successfully',
            'data' => new ConferenceResource($conference)
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Conference deleted successfully'
        ]);
    }
}
