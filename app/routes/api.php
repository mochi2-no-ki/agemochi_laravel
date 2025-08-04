<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RealtimeRoutine\RaiseHandController;
use App\Http\Controllers\Routine\RoutineController;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\TestPresenceChatController;
use App\Http\Controllers\TestPresenceChatLogController;
use App\Http\Controllers\TestPresenceEventController;
use App\Http\Controllers\TestPresenceEventLogController;
use App\Http\Controllers\TestPrivateChatController;
use App\Http\Controllers\TestPublicChatController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Sanctum を用いた API 認証対応ルート群です。
| 今後すべての API エンドポイントはこのグループ内にまとめて記述していきます。
*/

Route::middleware('api')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | 認証不要ルート（ログインなど）
    |--------------------------------------------------------------------------
    */

    // テスト用のソケット通信
    Route::prefix('socket')->group(function () {
        // テスト用の公開チャットメッセージ送信用ルート
        Route::post('/chat/public', [TestPublicChatController::class, 'send']);
        // テスト用の個別チャットメッセージ送信用ルート
        Route::post('/chat/private', TestPrivateChatController::class);
    });

    // ログイン処理（POST /api/login）
    Route::post('/login', [LoginController::class, 'login']);

    Route::prefix('routine')->group(function () {
        // ルーティーン一覧取得（GET /api/routine/list）テスト用
        Route::get('/list', [RoutineController::class, 'list']);
        // ルーティーン詳細取得（GET /api/routine/{routine_id}/detail）テスト用
        Route::get('/{routine_id}/detail', [RoutineController::class, 'showDetail']);
        // ルーティーン投稿（POST /api/routine/create）テスト用
        Route::post('/create', [RoutineController::class, 'create']);
        // リアルタイムルーティーン開催（POST /api/routine/{routine_id}/hold_event）テスト用
        Route::post('/{routine_id}/hold_event', [RoutineController::class, 'holdEvent']);
    });

    Route::prefix('rr')->group(function () {
        // 挙手通知（POST /api/rr/{realtime_routine_id}/raise-hand）
        Route::post('/{realtime_routine_id}/raise-hand', [RaiseHandController::class, 'raiseHand']);
    });

    // ユーザー簡易プロフィール取得（GET /api/user/{mochi_id}）
    Route::get('/user/{mochi_id}', [UserController::class, 'showSimpleProfile']);

    // タグ検索API（GET /api/tag/list）
    Route::prefix('tag')->group(function () {
        Route::get('/list', [TagController::class, 'list']);
    });

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

        // ルーティーン一覧取得（GET /api/routine/list）
        // Route::prefix('routine')->group(function () {
        //     Route::get('/list', [RoutineController::class, 'list']);
        // });

        // 今後、認証必須のAPIはここに追加

        Route::prefix('auth_socket')->group(function () {
            // テスト用の presence チャット送信用ルート
            Route::post('/chat/presence', [TestPresenceChatController::class, 'send']);
            // チャット履歴取得
            Route::get('/chat/presence/log', [TestPresenceChatLogController::class, 'getLog']);

            // テスト用の presence event送信用ルート
            Route::post('/chat/test_presence_event', [TestPresenceEventController::class, 'send']);
            // eventチャット履歴取得
            Route::get('/chat/test_presence_event/log', [TestPresenceEventLogController::class, 'getLog']);
        });
    });
});

/*
|--------------------------------------------------------------------------
| Broadcasting Routes (認証付き Presence Channel 用)
|--------------------------------------------------------------------------
*/
Broadcast::routes([
    'middleware' => ['auth:sanctum'],
]);

Broadcast::channel('presence.test_presence_chat', function ($user) {
    return [
        'user_id' => $user->user_id,
        'mochi_id' => $user->mochi_id,
        'user_name' => $user->user_name,
    ];
});
