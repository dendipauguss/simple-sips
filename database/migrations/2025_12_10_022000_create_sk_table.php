<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sk', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->unsignedBigInteger('pengenaan_sp_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('pengenaan_sp_id')->references('id')->on('pengenaan_sp')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sk');
    }
};
