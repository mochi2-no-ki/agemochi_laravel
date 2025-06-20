<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_login', function (Blueprint $table) {
            // ユーザーID（user_account.user_idを参照）
            $table->string('user_id', 255)->primary();

            // メールアドレス（ユニーク制約あり）
            $table->string('mail', 255)->unique();

            // 暗号化されたパスワード
            $table->string('password', 255);

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
        Schema::dropIfExists('user_login');
    }
};
