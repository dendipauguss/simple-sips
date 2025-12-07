<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengenaanSanksiTable extends Migration
{
    public function up()
    {
        Schema::create('pengenaan_sanksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedBigInteger('pelaku_usaha_id');
            $table->unsignedBigInteger('sanksi_id');
            $table->text('perintah_sanksi_lainnya')->nullable();
            $table->string('deskripsi')->nullable();
            $table->enum('status_pengenaan_sanksi', ['belum', 'pending', 'selesai'])->default('belum');
            $table->unsignedBigInteger('perihal_id');
            $table->enum('status_lainnya', ['belum', 'sudah'])->default('belum');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('pelaku_usaha_id')->references('id')->on('pelaku_usaha')->onDelete('cascade');
            $table->foreign('sanksi_id')->references('id')->on('sanksi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengenaan_sanksi');
    }
}
