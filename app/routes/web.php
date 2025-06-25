<?php

use Illuminate\Support\Facades\Route;

Route::prefix('web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    // routes/web.php
    Route::get('/test_echo', function () {
        return view('test_echo');
    });

});
