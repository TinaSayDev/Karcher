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
        Schema::table('product_translations', function (Blueprint $table) {
            // Вернуть short_description
            if (!Schema::hasColumn('product_translations', 'short_description')) {
                $table->text('short_description')->nullable()->after('slug');
            }

            // Удаляем старые колонки
            if (Schema::hasColumn('product_translations', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('product_translations', 'specifications')) {
                $table->dropColumn('specifications');
            }
            if (Schema::hasColumn('product_translations', 'equipment')) {
                $table->dropColumn('equipment');
            }

            // Добавляем новое JSON-поле tabs
            if (!Schema::hasColumn('product_translations', 'tabs')) {
                $table->json('tabs')->nullable()->after('short_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_translations', function (Blueprint $table) {
            // Откат без учета данных (структура)
            $table->dropColumn('tabs');

            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->text('equipment')->nullable();

            $table->dropColumn('short_description');
        });
    }
};
