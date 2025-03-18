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
        Schema::create('t_parameter', function (Blueprint $table) {
            $table->id();  // Primary key (id)
            $table->string('email')->nullable();  // Email address
            $table->string('no_telepon')->nullable();  // Phone number
            $table->string('no_wa')->nullable();  // WhatsApp number
            $table->string('address')->nullable();  // Address
            $table->text('maps_url')->nullable();  // Google Maps embed code or URL
            $table->text('maps_iframe')->nullable();
            $table->text('visi')->nullable();  // Vision statement
            $table->text('misi')->nullable();  // Mission statement
            $table->string('logo')->nullable();  // Logo image URL or path
            $table->string('logo_support_2')->nullable();  // Logo image URL or path
            $table->string('logo_support_3')->nullable();  // Logo image URL or path
            $table->string('instagram')->nullable();  // Instagram URL
            $table->string('linkedin')->nullable();  // LinkedIn URL (corrected 'linkin' to 'linkedin')
            $table->string('ekatalog')->nullable();  // E-catalog link
            $table->string('no_acc_bank')->nullable();
            $table->string('bank')->nullable();

            $table->string('company_name')->nullable();  // Company name
            $table->text('short_history')->nullable();  // Short history of the company
            $table->string('about_gambar')->nullable();  // Image for the "About" section


            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compro_parameter');
    }
};
