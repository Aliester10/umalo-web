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
        Schema::create('t_product_brosur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('t_product')->onDelete('cascade'); // Ensures that the linked product must exist and deletes related records when the product is deleted.
            $table->string('file'); 
            $table->enum('type', ['pdf', 'image']); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brosur');
    }
};
