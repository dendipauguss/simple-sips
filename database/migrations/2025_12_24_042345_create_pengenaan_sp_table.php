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
            $table->string('no_surat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedBigInteger('nota_dinas_id');
            $table->unsignedBigInteger('sanksi_id');
            $table->unsignedBigInteger('jenis_pelaku_usaha_id');
            $table->unsignedBigInteger('pelaku_usaha_id');
            $table->unsignedBigInteger('jenis_pelanggaran_id');
            $table->unsignedBigInteger('kategori_sp_id');
            $table->text('detail_pelanggaran')->nullable();
            $table->string('tanggapan')->nullable();
            $table->enum('status_surat', ['pending', 'belum_ditanggapi', 'sudah_ditanggapi'])->default('belum_ditanggapi');
            // $table->enum('status_laporan', ['acc', 'pending', 'return'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('nota_dinas_id')->references('id')->on('nota_dinas')->onDelete('cascade');
            $table->foreign('sanksi_id')->references('id')->on('sanksi')->onDelete('cascade');
            $table->foreign('jenis_pelaku_usaha_id')->references('id')->on('jenis_pelaku_usaha')->onDelete('cascade');
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
