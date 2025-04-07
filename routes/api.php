<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\ConferenceEditorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    //add routes that are restricted to admin
});

Route::middleware(['auth:sanctum', 'role:admin,editor'])->group(function () {
    //add routes that are restricted to admin and editor
    Route::post('/upload', [FileController::class, 'store']);
    Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');
});

Route::middleware('auth:sanctum')->group(function () {
    // User profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Conference routes
    Route::apiResource('conferences', ConferenceController::class);

    // User management routes
    Route::apiResource('users', UserController::class);

    // Conference editors routes
    Route::get('conferences/{conference}/editors', [ConferenceEditorController::class, 'getEditors']);
    Route::get('conferences/{conference}/available-editors', [ConferenceEditorController::class, 'getAvailableEditors']);
    Route::post('conferences/{conference}/editors', [ConferenceEditorController::class, 'assignEditor']);
    Route::delete('conferences/{conference}/editors/{editor}', [ConferenceEditorController::class, 'removeEditor']);
});

// I change it to secure one
//Route::get('/user', function (Request $request) {
//    return $request->user();
//});
