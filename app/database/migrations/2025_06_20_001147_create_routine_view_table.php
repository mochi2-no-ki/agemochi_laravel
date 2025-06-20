<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routine_view', function (Blueprint $table) {
            // ルーティーンID（主キー、外部キー）
            $table->string('routine_id', 255)->primary();

            // 参考になったカウント（初期値0）
            $table->unsignedInteger('reference_count')->default(0);

            // 閲覧数カウント（初期値0）
            $table->unsignedInteger('view_count')->default(0);

            // 作成・更新日時
            $table->timestamps();

            // 外部キー制約
            $table->foreign('routine_id')
                ->references('routine_id')
                ->on('routine')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routine_view');
    }
};
