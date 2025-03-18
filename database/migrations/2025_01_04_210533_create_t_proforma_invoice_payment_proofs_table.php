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
        Schema::create('t_proforma_invoice_payment_proofs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proforma_invoice_id'); // Foreign key to Proforma Invoice
            $table->string('proof_file_path'); // Path to the uploaded payment proof file
            $table->enum('payment_type', ['dp', 'balance'])->default('dp'); // Type of payment
            $table->string('status')->default('pending'); // Status: pending, approved, rejected
            $table->text('remarks')->nullable(); // Additional remarks
            $table->text('admin_remarks')->nullable();
            $table->boolean('is_viewed_admin')->default(false);
            $table->boolean('is_viewed_distributor')->default(true);
            $table->timestamps();

            $table->foreign('proforma_invoice_id')->references('id')->on('t_proforma_invoice')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_proforma_invoice_payment_proofs');
    }
};
