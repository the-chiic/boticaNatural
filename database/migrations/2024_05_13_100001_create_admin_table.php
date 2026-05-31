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
        Schema::create('admin', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50)->nullable(false);
            $table->string('email', 100)->nullable(false)->unique('uni_email_admin');
            $table->string('pw', 255)->nullable(false);
            $table->string('google_auth', 255)->nullable();
            $table->string('phone', 25)->nullable();
            $table->enum('rol', ['admin'])->nullable(false)->default('admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
