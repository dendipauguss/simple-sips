<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengenaan_sp_sanksi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sanksi_id');
            $table->bigInteger('pengenaan_sp_id');
            $table->bigInteger('nominal_denda')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengenaan_sp_sanksi');
    }
};
