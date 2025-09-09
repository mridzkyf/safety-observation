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
    Schema::table('safety_observations', function (Blueprint $table) {
        $table->text('keterangan_status')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('safety_observations', function (Blueprint $table) {
        $table->dropColumn('keterangan_status');
    });
}
};
