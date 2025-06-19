<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tag', function (Blueprint $table) {
            // タグID（主キー）
            $table->string('tag_id', 255)->primary();

            // タグ名（ユニーク制約付き）
            $table->string('tag_name', 255)->unique();

            // 作成・更新・削除日時
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag');
    }
};
