<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realtime_routine', function (Blueprint $table) {
            // 開催ルーティーンID（主キー）
            $table->string('realtime_routine_id', 255)->primary();

            // 参照元ルーティーンID
            $table->string('routine_id', 255);

            // 開催者ユーザーID
            $table->string('owner_user_id', 255);

            // タイトル（コピー時点の情報）
            $table->string('realtime_routine_title', 255);

            // 開始時刻
            $table->dateTime('start_time');

            // 終了予定時刻
            $table->dateTime('end_time');

            // 実際の終了時刻（nullable）
            $table->dateTime('actual_end_time')->nullable();

            // 状態ID
            $table->string('realtime_status_id', 255);

            // 作成日時・更新日時
            $table->timestamps();

            // 外部キー制約
            $table->foreign('routine_id')
                ->references('routine_id')
                ->on('routine')
                ->onDelete('cascade');

            $table->foreign('owner_user_id')
                ->references('user_id')
                ->on('user_account')
                ->onDelete('cascade');

            $table->foreign('realtime_status_id')
                ->references('realtime_status_id')
                ->on('realtime_status')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realtime_routine');
    }
};
