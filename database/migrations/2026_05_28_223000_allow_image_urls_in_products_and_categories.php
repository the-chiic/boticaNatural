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
        // Modificar la tabla 'category'
        Schema::table('category', function (Blueprint $table) {
            // Eliminar el índice único de 'img' si existe para evitar conflictos al usar URLs o nulls
            try {
                $table->dropUnique('uni_img');
            } catch (\Exception $e) {
                // Ignorar si no existe
            }
        });

        Schema::table('category', function (Blueprint $table) {
            $table->string('img', 2048)->nullable()->change();
        });

        // Modificar la tabla 'product'
        if (!Schema::hasColumn('product', 'image_url')) {
            Schema::table('product', function (Blueprint $table) {
                $table->string('image_url', 2048)->nullable()->after('promotion_id');
            });
        }

        Schema::table('product', function (Blueprint $table) {
            $table->unsignedInteger('img_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->unsignedInteger('img_id')->nullable(false)->change();
            if (Schema::hasColumn('product', 'image_url')) {
                $table->dropColumn('image_url');
            }
        });

        Schema::table('category', function (Blueprint $table) {
            $table->string('img', 100)->nullable(false)->change();
            try {
                $table->unique('img', 'uni_img');
            } catch (\Exception $e) {
                // Ignorar si falla al revertir
            }
        });
    }
};
