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
        Schema::create('t_ticketing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('service_type', ['Permintaan Data', 'Maintenance', 'Visit', 'Installasi', 'Lainnya']); // ENUM untuk jenis layanan
            $table->text('submission_description'); 
            $table->text('supporting_document')->nullable(); 
            $table->enum('status', ['Open', 'Progress', 'Close', 'Batal']); // Status tiket
            $table->date('action_start_date')->nullable(); // Tanggal tindakan
            $table->date('action_close_date')->nullable(); // Tanggal penutupan
            $table->string('technician')->nullable(); // Nama teknisi atau tim teknisi
            $table->text('action_description')->nullable(); // Keterangan tindakan
            $table->text('action_document')->nullable(); // Dokumen tindakan
            $table->boolean('is_viewed_admin')->default(false);
            $table->boolean('is_viewed_member')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('t_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_ticketing');
    }
};
