<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('t_banner', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->string('title');
            $table->string('subtitle');
            $table->text('description');
            $table->string('button_text');
            $table->string('button_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
