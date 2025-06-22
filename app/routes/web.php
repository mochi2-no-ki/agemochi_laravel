<?php

use Illuminate\Support\Facades\Route;

Route::prefix('web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
