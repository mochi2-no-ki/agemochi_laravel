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
