<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaku_usaha', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('jenis_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('jenis_id')
                ->references('id')
                ->on('jenis_pelaku_usaha')
                ->onDelete('restrict'); // atau cascade / set null
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaku_usaha');
    }
};
