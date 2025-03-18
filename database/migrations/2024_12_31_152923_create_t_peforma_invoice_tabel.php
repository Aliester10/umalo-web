<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_proforma_invoice', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('purchase_order_id');
            $table->string('pi_number')->unique(); // Unique Proforma Invoice Number
            $table->decimal('subtotal', 15, 2)->default(0); // Subtotal
            $table->decimal('ppn', 15, 2)->default(0); // PPN
            $table->decimal('grand_total_include_ppn', 15, 2)->default(0); // Grand total including PPN
            $table->decimal('dp', 15, 2)->default(0); // Down Payment
            $table->decimal('grand_total_after_dp', 15, 2)->default(0); // Grand total after DP
            $table->string('file_path')->nullable(); // Path to file
            $table->text('remarks')->nullable(); // Additional remarks
            $table->enum('status', ['pending', 'partially_paid', 'paid', 'overdue'])->default('pending'); // Invoice status
            $table->unsignedBigInteger('quotation_id')->nullable(); // Foreign key to Quotation
            $table->boolean('is_viewed_admin')->default(true);
            $table->boolean('is_viewed_distributor')->default(false);
            $table->timestamps(); // created_at and updated_at columns
        
            // Relationships
            $table->foreign('purchase_order_id')->references('id')->on('t_purchase_orders')->onDelete('cascade');
            $table->foreign('quotation_id')->references('id')->on('t_quotations')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_proforma_invoice');
    }
};
