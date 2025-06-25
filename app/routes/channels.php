<?php

use Illuminate\Support\Facades\Broadcast;

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
/*
Broadcast::channel('test_private_chat.{userId}', function ($user, $userId) {
    return (string) $user->id === (string) $userId;
});
*/
