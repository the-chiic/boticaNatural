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
        // Eliminar la foreign key existente
        Schema::table('order_line', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        // Recrear la foreign key con onDelete('cascade')
        Schema::table('order_line', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a la versión original sin onDelete
        Schema::table('order_line', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('order_line', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onUpdate('cascade');
        });
    }
};
