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
            'file' => 'required|file',
        ]);
        
        $file = $request->file('file');
        
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        $path = $file->storeAs('uploads', $fileName);
        
        $fileObject =[
            'name' => $file->getClientOriginalName() ,
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize()
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
}
