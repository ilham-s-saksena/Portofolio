<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return response()->json(["message" => "Server is Running"],200);
});

Route::get('/{slug}', [PublicController::class,'index']);
Route::post('register' , [AuthController::class,'register']);
