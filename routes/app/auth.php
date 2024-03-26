<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login' , [AuthController::class,'login']);
Route::post('register' , [AuthController::class,'register']);

Route::middleware(['auth:sanctum'])->prefix('self')->group(function () {
    Route::get('/info' , [AuthController::class,'self_info']);
});