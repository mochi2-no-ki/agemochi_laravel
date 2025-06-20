<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routine_tag', function (Blueprint $table) {
            // ルーティーンタグID（主キー）
            $table->string('routine_tag_id', 255)->primary();

            // ルーティーンID（外部キー）
            $table->string('routine_id', 255);

            // タグID（外部キー）
            $table->string('tag_id', 255);

            // 作成日時
            $table->timestamp('created_at')->useCurrent();

            // 複合ユニーク制約：routine_id と tag_id の組み合わせ
            $table->unique(['routine_id', 'tag_id']);

            // 外部キー制約
            $table->foreign('routine_id')
                ->references('routine_id')
                ->on('routine')
                ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('tag_id')
                ->on('tag')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routine_tag');
    }
};
