<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_type', function (Blueprint $table) {
            // メッセージ種別ID（例: 001, 002）
            $table->string('message_type_id', 255)->primary();

            // メッセージ種別（例: normal, opening, etc）
            $table->string('message_type', 255);

            // タイムスタンプ類
            $table->timestamps();
            $table->softDeletes(); // 削除日時 (deleted_at)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_type');
    }
};
