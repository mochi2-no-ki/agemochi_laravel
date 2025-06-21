<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Sanctum を用いた API 認証対応ルート群です。
| 今後すべての API エンドポイントはこのグループ内にまとめて記述していきます。
|
*/

Route::middleware('api')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | 認証不要ルート（ログインなど）
    |--------------------------------------------------------------------------
    */

    // ログイン処理（POST /api/login）
    Route::post('/login', [LoginController::class, 'login']);

    /*
    |--------------------------------------------------------------------------
    | 認証済みユーザー向けルート（トークン必須）
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {
        // ログアウト処理（POST /api/logout）
        Route::post('/logout', [LoginController::class, 'logout']);

        // // ユーザー情報取得（GET /api/user）
        // Route::get('/user', function (Request $request) {
        //     return $request->user(); // 認証済みの UserAccount モデルを返す
        // });

        // 今後、認証必須のAPIはここに追加
    });
});
