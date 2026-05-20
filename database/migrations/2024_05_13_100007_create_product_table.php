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
            $table->string('name', 150);
            $table->string('description', 200)->nullable();
            $table->boolean('status')->default(1);
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotion')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
