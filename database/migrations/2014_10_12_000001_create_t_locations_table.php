<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('t_locations', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->decimal('latitude', 8, 6); // Latitude dengan presisi 8 dan skala 6
            $table->decimal('longitude', 9, 6); // Longitude dengan presisi 9 dan skala 6
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
