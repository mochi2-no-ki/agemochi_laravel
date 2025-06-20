<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_account', function (Blueprint $table) {
            $table->string('user_id', 255)->primary(); // UUIDv7はモデル側で生成
            $table->string('mochi_id', 255)->unique(); // ユーザーが指定するアプリID
            $table->string('user_name', 255);
            $table->string('user_img_path', 255)->nullable();
            $table->text('introduction')->nullable();
            $table->string('current_user_banner_id', 255)->nullable();
            $table->string('current_icon_frame_id', 255)->nullable();
            $table->timestamps();

            // 外部キー（現時点では未定義のためコメントアウト）
            /*
            $table->foreign('current_user_banner_id')
            ->references('banner_id')
            ->on('banner')
            ->nullOnDelete();

            $table->foreign('current_icon_frame_id')
            ->references('icon_frame_id')
            ->on('icon_frame')
            ->nullOnDelete();
            */
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_account');
    }
};
