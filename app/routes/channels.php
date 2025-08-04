<?php

use App\Models\UserLogin;
use App\Services\RealtimeRoutine\ChannelAuthService;
use Illuminate\Support\Facades\Broadcast;

// ユーザー自身のIDに対する公開チャンネル認可
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// ✅ TestMessage 用のチャンネル認可（public チャンネルのため true でOK）
Broadcast::channel('test_channel', function () {
    return true;
});

// ✅ PublicChatMessage 用のチャンネル認可（public チャンネルのため true でOK）
Broadcast::channel('test_public_chat', function () {
    return true;
});

// ✅ TestPrivateChat 用のチャンネル認可
// 現在は public チャンネルを使用しているため、true を返す
Broadcast::channel('test_private_chat.{userId}', function () {
    return true;
});

// 将来的に private チャンネルへ移行する場合（認証あり）
// Broadcast::channel('test_private_chat.{userId}', function ($user, $userId) {
//     return (string) $user->id === (string) $userId;
// });

// ✅ Presence チャンネル（ログイン済みユーザーのみ参加可）
// $user は Sanctum 経由で認証された UserLogin モデル
Broadcast::channel('test_presence_chat', function (UserLogin $userLogin) {
    $account = $userLogin->userAccount;

    return [
        'user_id' => $account->user_id,
        'mochi_id' => $account->mochi_id,
        'user_name' => $account->user_name,
    ];
});

// ✅ TestPresenceChat 用 private チャンネル（個別チャット用）
Broadcast::channel('test_presence_chat.{mochiId}', function (UserLogin $userLogin, string $mochiId) {
    return $userLogin->userAccount->mochi_id === $mochiId;
});

// ✅ RealtimeRoutine Presence チャンネル認可
Broadcast::channel('presence_realtime_routine.{realtimeRoutineId}', function (UserLogin $userLogin, string $realtimeRoutineId) {
    $authService = app(ChannelAuthService::class);

    if (! $authService->isAccessible($realtimeRoutineId)) {
        return false;
    }

    $account = $userLogin->userAccount;

    return [
        'user_id' => $account->user_id,
        'mochi_id' => $account->mochi_id,
        'user_name' => $account->user_name,
    ];
});

// ✅ RealtimeRoutine Private チャンネル認可
Broadcast::channel('private_realtime_routine.{realtimeRoutineId}.{mochiId}', function (UserLogin $userLogin, string $realtimeRoutineId, string $mochiId) {
    $authService = app(ChannelAuthService::class);

    if (! $authService->isAccessible($realtimeRoutineId)) {
        return false;
    }

    return $userLogin->userAccount->mochi_id === $mochiId;
});
