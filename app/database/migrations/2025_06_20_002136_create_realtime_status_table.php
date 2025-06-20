<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realtime_status', function (Blueprint $table) {
            // 状態ID（主キー）
            $table->string('realtime_status_id', 255)->primary();

            // 状態名（例: scheduled, ongoing, ended）
            $table->string('realtime_status', 255);

            // 作成日時・更新日時・削除日時
            $table->timestamps();
            $table->softDeletes(); // deleted_at カラムを自動追加
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realtime_status');
    }
};
