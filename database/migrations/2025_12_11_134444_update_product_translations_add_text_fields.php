<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_translations', function (Blueprint $table) {
            // Добавляем новые текстовые поля
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->text('equipment')->nullable();

            // Удаляем колонку tabs, если она существует
            if (Schema::hasColumn('product_translations', 'tabs')) {
                $table->dropColumn('tabs');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_translations', function (Blueprint $table) {
            // Откат: убираем новые поля
            $table->dropColumn(['description', 'specifications', 'equipment']);

            // Возвращаем tabs обратно
            $table->json('tabs')->nullable();
        });
    }
};
