<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            $table->unsignedBigInteger('dasar_pengenaan_sanksi_id');

            $table->foreign('dasar_pengenaan_sanksi_id')->references('id')->on('dasar_pengenaan_sanksi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_pelanggaran', function (Blueprint $table) {
            $table->dropColumn('dasar_pengenaan_sanksi_id');
        });
    }
};
