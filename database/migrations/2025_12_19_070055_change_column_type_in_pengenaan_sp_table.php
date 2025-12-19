<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengenaan_sp', function (Blueprint $table) {
            $table->text('detail_pelanggaran')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pengenaan_sp', function (Blueprint $table) {
            $table->string('detail_pelanggaran')->nullable()->change();
        });
    }
};
