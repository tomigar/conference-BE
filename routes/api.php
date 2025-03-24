<?php

use App\Http\Controllers\API\AuthController;
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
});

Route::get('/user', function (Request $request) {
    return $request->user();
});
