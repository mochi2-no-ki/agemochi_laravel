<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realtime_routine_participant', function (Blueprint $table) {
            // 主キー
            $table->string('realtime_routine_participant_id', 255)->primary();

            // 開催ルーティーンID
            $table->string('realtime_routine_id', 255);

            // 参加ユーザーID
            $table->string('user_id', 255);

            // 作成日時
            $table->timestamp('created_at')->useCurrent();

            // 複合ユニーク制約：realtime_routine_id と user_id の組み合わせ
            $table->unique(['realtime_routine_id', 'user_id']);

            // 外部キー制約
            $table->foreign('realtime_routine_id')
                ->references('realtime_routine_id')
                ->on('realtime_routine')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('user_account')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realtime_routine_participant');
    }
};
