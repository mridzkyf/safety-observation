<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('safety_observations', function (Blueprint $table) {
            $table->dropColumn(['metode', 'jenis_temuan']);
        });
    }

    public function down(): void
    {
        Schema::table('safety_observations', function (Blueprint $table) {
            $table->string('metode')->nullable(); // Bisa sesuaikan tipe datanya dengan yang dulu
            $table->text('jenis_temuan')->nullable();   // Sesuaikan juga
        });
    }
};
