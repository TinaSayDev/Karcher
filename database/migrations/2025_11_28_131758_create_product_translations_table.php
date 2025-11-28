<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->string('locale', 5);  // ru/en/uz

            // Основные текстовые поля
            $table->string('name');
            $table->string('slug');

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable(); // основной текст
            $table->longText('description_html')->nullable();
            $table->longText('specifications_html')->nullable();
            $table->longText('equipment_html')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();

            $table->unique(['product_id', 'locale']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
