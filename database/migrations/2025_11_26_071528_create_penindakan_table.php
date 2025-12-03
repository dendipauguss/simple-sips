<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenindakanTable extends Migration
{
    public function up()
    {
        Schema::create('penindakan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedBigInteger('perusahaan_id');
            $table->unsignedBigInteger('sanksi_id');
            $table->text('perintah_lainnya')->nullable();
            $table->string('deskripsi')->nullable();
            $table->enum('status', ['belum', 'pending', 'selesai'])->default('belum');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('perusahaan_id')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->foreign('sanksi_id')->references('id')->on('sanksi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penindakan');
    }
}
