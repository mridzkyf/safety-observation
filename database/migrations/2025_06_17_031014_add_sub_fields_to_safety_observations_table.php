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
    Schema::table('safety_observations', function (Blueprint $table) {
        $table->string('sub_metode')->nullable();
        $table->string('sub_alat')->nullable();
        $table->string('sub_apd')->nullable();
        $table->string('sub_5s')->nullable();
        $table->string('sub_posisi')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('safety_observations', function (Blueprint $table) {
        $table->dropColumn([
            'sub_metode',
            'sub_alat',
            'sub_apd',
            'sub_5s',
            'sub_posisi',
        ]);
    });
    }
};
