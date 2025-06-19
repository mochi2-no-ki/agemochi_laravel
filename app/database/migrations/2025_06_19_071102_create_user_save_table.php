<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_save', function (Blueprint $table) {
            // ユーザーID（user_account.user_idを参照） - 主キーかつ外部キー
            $table->string('user_id', 255)->primary();

            // ルーティーンの最大保存数（デフォルト30）
            $table->unsignedInteger('routine_save_max')->default(30);

            // リアルタイムルーティーンの最大保存数（デフォルト10）
            $table->unsignedInteger('realtime_routine_save_max')->default(10);

            // 作成・更新日時
            $table->timestamps();

            // 外部キー制約：ユーザー削除時に連動削除
            $table->foreign('user_id')
                ->references('user_id')
                ->on('user_account')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_save');
    }
};
