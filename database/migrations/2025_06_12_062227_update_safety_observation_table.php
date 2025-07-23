<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('safety_observations', function (Blueprint $table) {
            $table->string('jenis_temuan')->nullable(); // tambahkan kolom baru
            $table->dropColumn('alat_fasilitas');       // hapus kolom lama
        });
    }

    public function down(): void
    {
        Schema::table('safety_observations', function (Blueprint $table) {
            $table->dropColumn('jenis_temuan'); // rollback: hapus kolom yang ditambahkan
            $table->string('alat_fasilitas')->nullable(); // rollback: tambahkan kembali kolom yang dihapus
        });
    }
};
