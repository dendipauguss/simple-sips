<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengenaan_perintah_sanksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengenaan_id');
            $table->unsignedBigInteger('perintah_sanksi_id');

            $table->foreign('pengenaan_id')
                ->references('id')->on('pengenaan_sanksi')
                ->onDelete('cascade');

            $table->foreign('perintah_sanksi_id')
                ->references('id')->on('perintah_sanksi')
                ->onDelete('cascade');

            $table->enum('status', ['belum', 'sudah'])->default('belum');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengenaan_perintah_sanksi');
    }
};
