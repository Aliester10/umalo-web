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
        Schema::create('t_quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('pending');
            $table->string('application_number');
            $table->string('topic');
            $table->string('quotation_number')->unique();
            $table->string('recipient_company');
            $table->string('recipient_contact_person');
            $table->decimal('discount', 15, 2)->default(0.00);
            $table->decimal('grand_total', 15, 2)->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->string('authorized_person_name')->nullable();
            $table->string('authorized_person_position')->nullable();
            $table->string('authorized_person_signature')->nullable();
            $table->decimal('subtotal_price', 15, 2)->nullable();
            $table->decimal('total_after_discount', 15, 2)->nullable();
            $table->decimal('ppn', 15, 2)->default(0.00)->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('is_viewed_distributor')->default(true);
            $table->string('is_viewed_admin')->default(false);

            $table->foreign('user_id')->references('id')->on('t_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_quotations');
    }
};
