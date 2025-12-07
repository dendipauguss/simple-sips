<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_sp', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('jenis_pelanggaran_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('jenis_pelanggaran_id')->references('id')->on('jenis_pelanggaran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_sp');
    }
};
