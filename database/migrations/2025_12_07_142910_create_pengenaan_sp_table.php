<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengenaan_sp', function (Blueprint $table) {
            $table->id();
            $table->string('no_sp')->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedBigInteger('pelaku_usaha_id');
            $table->unsignedBigInteger('jenis_pelanggaran_id');
            $table->unsignedBigInteger('kategori_sp_id');
            $table->string('detail_pelanggaran')->nullable();
            $table->string('tanggapan')->nullable();
            $table->enum('status_sp', ['belum', 'pending', 'selesai'])->default('belum');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('pelaku_usaha_id')->references('id')->on('pelaku_usaha')->onDelete('cascade');
            $table->foreign('jenis_pelanggaran_id')->references('id')->on('jenis_pelanggaran')->onDelete('cascade');
            $table->foreign('kategori_sp_id')->references('id')->on('kategori_sp')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengenaan_sp');
    }
};
