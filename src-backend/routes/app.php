<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(["message" => "Server is Running"],200);
});

Route::get('/{slug}', [PublicController::class,'index']);
