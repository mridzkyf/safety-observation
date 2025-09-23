<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posters', function (Blueprint $table) {
            $table->renameColumn('image_path', 'file_path');
        });
    }

    public function down(): void
    {
        Schema::table('posters', function (Blueprint $table) {
            $table->renameColumn('file_path', 'image_path');
        });
    }
};
