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
        Schema::create('t_ticketing_request_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticketing_id');
            $table->string('document_name');
            $table->string('document_path');
            $table->boolean('is_viewed_member')->default(true);
            $table->timestamps();

            $table->foreign('ticketing_id')->references('id')->on('t_ticketing')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_ticketing_request_data');
    }
};
