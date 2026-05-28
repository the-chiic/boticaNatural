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
        Schema::table('orders', function (Blueprint $table) {
            $table->index('order_date', 'idx_orders_order_date');
            $table->index('status', 'idx_orders_status');
        });

        Schema::table('product', function (Blueprint $table) {
            $table->index('status', 'idx_product_status');
            $table->index('price', 'idx_product_price');
        });

        Schema::table('user', function (Blueprint $table) {
            $table->index('created_at', 'idx_user_created_at');
        });

        Schema::table('product_category', function (Blueprint $table) {
            $table->index('category_id', 'idx_product_category_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_order_date');
            $table->dropIndex('idx_orders_status');
        });

        Schema::table('product', function (Blueprint $table) {
            $table->dropIndex('idx_product_status');
            $table->dropIndex('idx_product_price');
        });

        Schema::table('user', function (Blueprint $table) {
            $table->dropIndex('idx_user_created_at');
        });

        Schema::table('product_category', function (Blueprint $table) {
            $table->dropIndex('idx_product_category_category_id');
        });
    }
};
