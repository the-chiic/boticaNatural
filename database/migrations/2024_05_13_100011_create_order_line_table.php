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
        Schema::create('order_line', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->nullable(false);
            $table->unsignedInteger('num_line')->nullable(false);
            $table->unsignedSmallInteger('product_id')->nullable(false);
            $table->unsignedInteger('unit')->nullable(false);
            $table->decimal('price', 10, 2)->nullable(false);
            $table->decimal('total_price', 10, 2)->nullable(false);
            
            $table->primary(['order_id', 'num_line']);
            
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_line');
    }
};
