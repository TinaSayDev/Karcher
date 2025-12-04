<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_translations', function (Blueprint $table) {
            // Удаляем старые html и meta поля
            $dropColumns = [
                'specifications_html',
                'equipment_html',
                'description_html',
                'short_description',
                'meta_title',
                'meta_description',
                'meta_keywords',
            ];

            foreach ($dropColumns as $col) {
                if (Schema::hasColumn('product_translations', $col)) {
                    $table->dropColumn($col);
                }
            }

            // Добавляем новые JSON-поля, если их ещё нет
            if (!Schema::hasColumn('product_translations', 'specifications')) {
                $table->json('specifications')->nullable();
            }
            if (!Schema::hasColumn('product_translations', 'equipment')) {
                $table->json('equipment')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_translations', function (Blueprint $table) {
            // Восстанавливаем старые поля
            $table->text('specifications_html')->nullable();
            $table->text('equipment_html')->nullable();
            $table->text('description_html')->nullable();
            $table->text('short_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Удаляем новые поля
            if (Schema::hasColumn('product_translations', 'specifications')) {
                $table->dropColumn('specifications');
            }
            if (Schema::hasColumn('product_translations', 'equipment')) {
                $table->dropColumn('equipment');
            }
        });
    }
};
