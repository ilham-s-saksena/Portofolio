<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

Route::middleware(['auth:sanctum'])->prefix('self')->group(function () {
    Route::post('basic_info' , [StoreController::class,'basic_info']);
    Route::post('social_media' , [StoreController::class,'social_media']);
    Route::post('education' , [StoreController::class,'education']);
    Route::post('organization' , [StoreController::class,'organization']);
    Route::post('skill' , [StoreController::class,'skill']);
    Route::post('experience' , [StoreController::class,'experience']);
    Route::post('portofolio' , [StoreController::class,'portofolio']);
});
