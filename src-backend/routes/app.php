<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(["message" => "Server is Running"],200);
});
