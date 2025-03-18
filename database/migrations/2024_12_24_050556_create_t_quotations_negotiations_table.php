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
        Schema::create('t_quotations_negotiations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->string('status');
            $table->text('distributor_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->boolean('is_viewed_admin')->default(false);
            $table->boolean('is_viewed_distributor')->default(true);
            $table->timestamps();

            $table->foreign('quotation_id')->references('id')->on('t_quotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_quotations_negotiations');
    }
};
