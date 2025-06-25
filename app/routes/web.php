<?php

use Illuminate\Support\Facades\Route;

Route::prefix('web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/test_echo', function () {
        return view('test_echo');
    });

    // ✅ 公開チャット画面ルートを追加
    Route::get('/test_public_chat', function () {
        return view('test_public_chat');
    });
});
