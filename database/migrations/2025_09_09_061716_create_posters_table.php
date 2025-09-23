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
    Schema::create('posters', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable(); // judul poster
        $table->string('image_path');       // lokasi file
        $table->boolean('is_active')->default(true); // poster aktif/tidak
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posters');
    }
};
