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
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240'
        ]);
        
        $file = $request->file('file');
        
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        $path = $file->storeAs('uploads', $fileName, 'public');
        
        $fileObject = [
        'name' => $file->getClientOriginalName(),
        'path' => $path,
        'mime_type' => $file->getMimeType(),
        'size' => $file->getSize(),
        'url' => asset('storage/' . $path)
    ];
        File::create($fileObject);


        
        return $this->sendResponse(
            $fileObject,
            'File uploaded successfully',
            201
        );
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
