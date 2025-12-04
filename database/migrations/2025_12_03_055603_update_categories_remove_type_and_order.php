<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'type')) {
                $table->dropColumn('type');
            }

            if (Schema::hasColumn('categories', 'order')) {
                $table->dropColumn('order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1);
            $table->integer('order')->default(0);
        });
    }
};
