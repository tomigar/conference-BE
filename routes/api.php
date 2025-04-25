<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\ConferenceEditorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// PUBLIC routes - visible to everyone (unauthenticated)
Route::get('/conferences', [ConferenceController::class, 'index']);
Route::get('/conferences/{conference}', [ConferenceController::class, 'show']);
Route::get('/pages/{page}', [PageController::class, 'show']);
Route::get('/pages/slug/{slug}', [PageController::class, 'getBySlug']);
Route::get('conferences/{conference}/pages', [PageController::class, 'index']);
Route::post('/uploads/image', [UploadController::class, 'uploadImage']);


// Admin-only routes
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Add admin-specific routes here
});

// Editor and Admin routes
Route::middleware(['auth:sanctum', 'role:admin,editor'])->group(function () {
    Route::post('/upload', [FileController::class, 'store']);
    Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');

    // Page management
   // Route::get('conferences/{conference}/pages', [PageController::class, 'index']);
    Route::post('conferences/{conference}/pages', [PageController::class, 'store']);
    Route::put('/pages/{page}', [PageController::class, 'update']);
    Route::delete('/pages/{page}', [PageController::class, 'destroy']);
});

// Authenticated routes (both editor and admin)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Conference CRUD (excluding index and show, which are public)
    Route::apiResource('conferences', ConferenceController::class)->except(['index', 'show']);

    // User management
    Route::apiResource('users', UserController::class);

    // Editor assignment to conferences
    Route::get('conferences/{conference}/editors', [ConferenceEditorController::class, 'getEditors']);
    Route::get('conferences/{conference}/available-editors', [ConferenceEditorController::class, 'getAvailableEditors']);
    Route::post('conferences/{conference}/editors', [ConferenceEditorController::class, 'assignEditor']);
    Route::delete('conferences/{conference}/editors/{editor}', [ConferenceEditorController::class, 'removeEditor']);
});
