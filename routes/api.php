<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\ConferenceEditorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    //add routes that are restricted to admin
});

Route::middleware(['auth:sanctum', 'role:admin,editor'])->group(function () {
    //add routes that are restricted to admin and editor
    // Conference routes
    Route::apiResource('conferences', ConferenceController::class);

    Route::get('conferences/{conference}/editors', [ConferenceEditorController::class, 'getEditors']);
    Route::get('conferences/{conference}/available-editors', [ConferenceEditorController::class, 'getAvailableEditors']);
    Route::post('conferences/{conference}/editors', [ConferenceEditorController::class, 'assignEditor']);
    Route::delete('conferences/{conference}/editors/{editor}', [ConferenceEditorController::class, 'removeEditor']);

    Route::prefix('conferences/{conference}')->group(function () {
        Route::post('pages', [PageController::class, 'store']);
        Route::put('pages/{page}', [PageController::class, 'update']);
        Route::delete('pages/{page}', [PageController::class, 'destroy']);
    });
    // File upload routes
    Route::post('/upload', [FileController::class, 'store']);
    Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');
    Route::post('/files', [FileController::class, 'store']);
    Route::get('/pages/{page}/files', [FileController::class, 'getByPage']);


});

Route::middleware('auth:sanctum')->group(function () {
    // User profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // User management routes
    Route::apiResource('users', UserController::class)->except(['store', 'destroy']);
});


Route::get('/conferences', [ConferenceController::class, 'index']);
// Verejne prístupné čítanie konferencie a jej stránok
Route::get('/conferences/{conference}', [ConferenceController::class, 'show']);
Route::get('/conferences/{conference}/pages', [App\Http\Controllers\PageController::class, 'index']);
Route::get('/conferences/{conference}/pages/{page}', [App\Http\Controllers\PageController::class, 'show']);

Route::get('/pages/{page}', [App\Http\Controllers\PageController::class, 'show']);
Route::get('/pages/{page}/files', [FileController::class, 'getByPage']);

