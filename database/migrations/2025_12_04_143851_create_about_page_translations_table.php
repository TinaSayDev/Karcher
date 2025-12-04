<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_page_id')->constrained()->onDelete('cascade');
            $table->string('locale', 5); // 'ru', 'en', 'uz' и т.д.
            $table->string('title');
            $table->text('content'); // HTML-контент
            $table->timestamps();

            $table->unique(['about_page_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_page_translations');
    }
};
