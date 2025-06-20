<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message', function (Blueprint $table) {
            // メッセージID（主キー）
            $table->string('message_id', 255)->primary();

            // 開催ルーティーンID
            $table->string('realtime_routine_id', 255);

            // 送信者ユーザーID
            $table->string('user_id', 255);

            // メッセージ種別ID
            $table->string('message_type_id', 255);

            // メッセージ本文
            $table->text('message_body');

            // 返信先ユーザーID（nullable）
            $table->string('reply_user_id', 255)->nullable();

            // 作成日時
            $table->timestamp('created_at')->useCurrent();

            // 外部キー制約
            $table->foreign('realtime_routine_id')
                ->references('realtime_routine_id')
                ->on('realtime_routine')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('user_account')
                ->onDelete('cascade');

            $table->foreign('message_type_id')
                ->references('message_type_id')
                ->on('message_type')
                ->onDelete('cascade');

            $table->foreign('reply_user_id')
                ->references('user_id')
                ->on('user_account')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message');
    }
};
