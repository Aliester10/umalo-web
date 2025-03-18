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
        Schema::create('t_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('deed_of_establishment')->nullable();
            $table->string('nib_document')->nullable();
            $table->unsignedBigInteger(column: 'sector_id')->nullable(); // Buat kolom ini nullable
            $table->unsignedBigInteger('location_id')->nullable();
            $table->boolean('type')->default(false); //add type boolean Users: 0=>User, 1=>Admin, 2=>Manager
            $table->boolean('is_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();


            $table->foreign('sector_id')->references('id')->on('t_company_sectors')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('t_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_users');
    }
};
