<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Удаляем таблицу pivot
        Schema::dropIfExists('post_post_category');

        // Удаляем таблицу категорий
        Schema::dropIfExists('post_categories');
    }

    public function down(): void
    {
        // При откате можно создать пустые таблицы (или оставить пустыми)
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('post_post_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_category_id')->constrained()->onDelete('cascade');

        });
    }
};
