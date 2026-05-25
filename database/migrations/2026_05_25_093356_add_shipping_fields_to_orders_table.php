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
            $table->string('shipping_name', 100)->nullable();
            $table->string('shipping_address', 255)->nullable();
            $table->string('shipping_city', 100)->nullable();
            $table->string('shipping_post_code', 20)->nullable();
            $table->string('shipping_country', 100)->nullable();
            $table->string('shipping_phone', 30)->nullable();
            $table->string('shipping_method', 50)->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_name',
                'shipping_address',
                'shipping_city',
                'shipping_post_code',
                'shipping_country',
                'shipping_phone',
                'shipping_method',
                'shipping_cost',
            ]);
        });
    }
};
