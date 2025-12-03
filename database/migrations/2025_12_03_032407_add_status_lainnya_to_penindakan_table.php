<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penindakan', function (Blueprint $table) {
            $table->enum('status_lainnya', ['belum', 'sudah'])->default('belum');
        });
    }

    public function down(): void
    {
        Schema::table('penindakan', function (Blueprint $table) {
            $table->dropColumn('status_lainnya');
        });
    }
};
