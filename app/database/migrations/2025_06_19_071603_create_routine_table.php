<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routine', function (Blueprint $table) {
            // ルーティーンID（主キー）
            $table->string('routine_id', 255)->primary();

            // 投稿者ユーザーID（外部キー）
            $table->string('user_id', 255);

            // ルーティーンタイトル
            $table->string('routine_title', 255);

            // ルーティーンの開始・終了時刻（例: 08:00 や 22:30 など）
            $table->time('routine_start');
            $table->time('routine_end');

            // 所要時間（分）
            $table->unsignedInteger('routine_time');

            // 本文
            $table->text('routine_body');

            // リアルタイムルーティーン実施可能フラグ
            $table->boolean('realtime_routine_flag')->default(false);

            // 作成・更新・削除日時
            $table->timestamps();
            $table->softDeletes();

            // 外部キー：投稿者
            $table->foreign('user_id')
                ->references('user_id')
                ->on('user_account')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routine');
    }
};
