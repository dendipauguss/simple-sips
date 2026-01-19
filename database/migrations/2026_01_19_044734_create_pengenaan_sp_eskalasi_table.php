<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengenaan_sp_eskalasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengenaan_sp_id');
            $table->unsignedBigInteger('sanksi_id');
            // urutan eskalasi
            $table->integer('level');
            $table->string('no_surat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            // denda
            $table->boolean('is_denda')->default(false);
            $table->bigInteger('nominal_denda')->nullable();
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->timestamps();

            $table->foreign('pengenaan_sp_id')
                ->references('id')->on('pengenaan_sp')
                ->onDelete('cascade');
            $table->foreign('sanksi_id')
                ->references('id')->on('sanksi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengenaan_sp_eskalasi');
    }
};
