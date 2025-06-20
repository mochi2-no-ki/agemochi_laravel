<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routine_save', function (Blueprint $table) {
            // 保存ID（主キー）
            $table->string('routine_save_id', 255)->primary();

            // ユーザーID（外部キー）
            $table->string('user_id', 255);

            // ルーティーンID（外部キー）
            $table->string('routine_id', 255);

            // 作成日時
            $table->timestamp('created_at')->useCurrent();

            // 複合ユニーク制約：user_id と routine_id の組み合わせ
            $table->unique(['user_id', 'routine_id']);

            // 外部キー制約
            $table->foreign('user_id')
                ->references('user_id')
                ->on('user_save')
                ->onDelete('cascade');

            $table->foreign('routine_id')
                ->references('routine_id')
                ->on('routine')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routine_save');
    }
};
