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
        Schema::create('safety_observations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('nama_seksi');
            $table->string('group');
            $table->string('lokasi_kerja');
            $table->date('tanggal_pelaporan');
            $table->string('lokasi_observasi');
            $table->string('judul_temuan');
            $table->string('kategori');
            $table->string('jenis_temuan');
            $table->string('bukti_gambar')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_observations');
    }
};
