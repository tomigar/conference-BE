<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends BaseController
{
    public function store(Request $request)
    {
      
        try {
        $request->validate([
            'file'     => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
            'page_id'  => 'required|integer|exists:pages,id',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $fileName, 'public');

        $fileData = [
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'url' => asset('storage/' . $path),
            'page_id' => $request->input('page_id'),
        ];

        $file = File::create($fileData);

        return response()->json($fileData, 201);
    } catch (\Exception $e) {
        \Log::error('File upload failed: ' . $e->getMessage());
        return response()->json([
            'message' => 'Upload failed',
            'error' => $e->getMessage(),
        ], 500);
    }
    }
    
    public function show($id)
    {
        $file = File::findOrFail($id);
        return Storage::download($file->path, $file->original_name);
    }

    public function getByPage($pageId)
{
    $files = \App\Models\File::where('page_id', $pageId)->get();

    return response()->json([
        'data' => $files,
    ]);
}

}
