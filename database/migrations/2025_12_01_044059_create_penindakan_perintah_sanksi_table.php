<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penindakan_perintah_sanksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penindakan_id');
            $table->unsignedBigInteger('perintah_sanksi_id');

            $table->foreign('penindakan_id')
                ->references('id')->on('penindakan')
                ->onDelete('cascade');

            $table->foreign('perintah_sanksi_id')
                ->references('id')->on('perintahsanksi')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penindakan_perintah_sanksi');
    }
};
