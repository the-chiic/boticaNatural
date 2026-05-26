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
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable(false);
            $table->string('address', 255)->nullable(false)->unique('uni_address_address');
            $table->string('province', 50)->nullable();
            $table->string('city', 50)->nullable(false);
            $table->string('post_code', 15)->nullable();
            $table->string('country', 100)->nullable(false);
            $table->string('phone', 25)->nullable();
            $table->string('name_destination', 50)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
