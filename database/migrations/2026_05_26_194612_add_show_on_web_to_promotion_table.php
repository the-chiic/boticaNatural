<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('promotion', 'show_on_web')) {
            Schema::table('promotion', function (Blueprint $table) {
                $table->boolean('show_on_web')->default(1)->after('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('promotion', 'show_on_web')) {
            Schema::table('promotion', function (Blueprint $table) {
                $table->dropColumn('show_on_web');
            });
        }
    }
};
