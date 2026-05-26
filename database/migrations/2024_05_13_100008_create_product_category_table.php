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
        Schema::create('product_category', function (Blueprint $table) {
            $table->unsignedSmallInteger('product_id')->nullable(false);
            $table->unsignedTinyInteger('category_id')->nullable(false);
            
            $table->primary(['product_id', 'category_id']);
            
            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreign('category_id')
                ->references('id')
                ->on('category')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category');
    }
};
