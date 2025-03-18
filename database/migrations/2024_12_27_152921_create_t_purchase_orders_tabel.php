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
        Schema::create('t_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id'); // Foreign key to quotations table
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('po_number')->unique(); // PO number, must be unique
            $table->enum('status', ['pending', 'approved', 'rejected','close'])->default('pending'); // Status of the PO
            $table->string('file_path'); // Path to the uploaded file
            $table->string('is_viewed_distributor')->default(true);
            $table->string('is_viewed_admin')->default(false);
            $table->timestamps();



            $table->foreign('quotation_id')->references('id')->on('t_quotations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('t_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_purchase_orders');
    }
};
