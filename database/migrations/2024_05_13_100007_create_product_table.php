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
        Schema::create('product', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('promotion_id')->nullable();
            $table->unsignedInteger('img_id')->nullable(false);
            $table->string('name', 150)->nullable(false);
            $table->string('description', 200)->nullable(false);
            $table->boolean('status')->nullable(false)->default(1);
            $table->decimal('price', 10, 2)->nullable(false);
            $table->unsignedInteger('stock')->nullable(false)->default(0);
            $table->timestamps();

            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotion')
                ->onUpdate('cascade')
                ->onDelete('set null');
                
            $table->foreign('img_id')
                ->references('id')
                ->on('product_img')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
