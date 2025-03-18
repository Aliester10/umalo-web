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
        Schema::create('t_user_product_documentation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_product_id'); // Foreign key ke t_users_product
            $table->string('status'); // Status dokumentasi
            $table->timestamps();

            $table->foreign('users_product_id')->references('id')->on('t_users_product')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_user_product_documentation');
    }
};
