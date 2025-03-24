<?php

use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConferenceEditorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('conferences', ConferenceController::class);

// User management routes
Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);

// Conference editor assignment routes
Route::get('conferences/{conference}/editors', [ConferenceEditorController::class, 'index'])
    ->name('conferences.editors.index');
Route::post('conferences/{conference}/editors', [ConferenceEditorController::class, 'store'])
    ->name('conferences.editors.store');
Route::delete('conferences/{conference}/editors/{editor}', [ConferenceEditorController::class, 'destroy'])
    ->name('conferences.editors.destroy');
