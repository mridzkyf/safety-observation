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
            $table->unsignedBigInteger('sic_id')->nullable()->after('nama_seksi');
            $table->string('status')->default('waiting')->after('sic_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::table('safety_observations', function (Blueprint $table) {
            $table->dropColumn(['sic_id', 'status']);
        });
    }

};
