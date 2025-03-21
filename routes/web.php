<?php

use App\Http\Controllers\ConferenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('conferences', ConferenceController::class);
