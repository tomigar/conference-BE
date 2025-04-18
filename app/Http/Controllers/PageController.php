<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Page;
use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends BaseController
{
    /**
     * Zoznam všetkých podstránok pre konkrétnu konferenciu.
     */
    public function index(Conference $conference)
    {
        $pages = $conference->pages()->orderBy('title')->get();
        return $this->sendResponse($pages, 'Zoznam podstránok načítaný.');
    }

    /**
     * Vytvorenie novej podstránky.
     */
    public function store(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ]);

        $page = $conference->pages()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'] ?? '',
        ]);

        return $this->sendResponse($page, 'Podstránka bola úspešne vytvorená.', 201);
    }

    /**
     * Zobrazenie jednej podstránky.
     */
    public function show(Page $page)
    {
        return $this->sendResponse($page, 'Podstránka načítaná.');
    }

    /**
     * Získanie podstránky podľa slug.
     */
    public function getBySlug(string $slug)
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found.'], 404);
        }

        return response()->json(['data' => $page]);
    }

    /**
     * Aktualizácia podstránky.
     */
    public function update(Request $request, Conference $conference, Page $page)
    {
        if ($page->conference_id !== $conference->id) {
            return $this->sendError('Podstránka nepatrí do tejto konferencie.', 403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
        ]);

        $page->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'] ?? '',
        ]);

        return $this->sendResponse($page, 'Podstránka bola úspešne upravená.');
    }

    /**
     * Zmazanie podstránky.
     */
    public function destroy(Conference $conference, Page $page)
    {
        if ($page->conference_id !== $conference->id) {
            return $this->sendError('Podstránka nepatrí do tejto konferencie.', 403);
        }

        $page->delete();

        return $this->sendResponse(null, 'Podstránka bola úspešne vymazaná.');
    }
}
