<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengenaan_sp', function (Blueprint $table) {
            $table->dropForeign(['sanksi_id']);
            $table->dropColumn('sanksi_id');
        });
    }

    public function down(): void
    {
        Schema::table('pengenaan_sp', function (Blueprint $table) {
            $table->unsignedBigInteger('sanksi_id');
            $table->foreign('sanksi_id')->references('id')->on('sanksi')->onDelete('cascade');
        });
    }
};
