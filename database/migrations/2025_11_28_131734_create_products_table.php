<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id');

            $table->string('code')->nullable(); // SKU / артикул

            // цены (если нужно будущая логика)
            $table->decimal('price_old', 10, 2)->nullable();
            $table->decimal('price_new', 10, 2)->nullable();

            // фото
            $table->string('image_main')->nullable();
            $table->json('images')->nullable();           // галерея
            $table->json('catalog_images')->nullable();   // фото для каталога

            // параметры, характеристики, комплектация
            $table->json('specifications')->nullable(); // JSON
            $table->json('equipment')->nullable();       // JSON

            // флаги
            $table->boolean('is_hit')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_sale')->default(false);

            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
