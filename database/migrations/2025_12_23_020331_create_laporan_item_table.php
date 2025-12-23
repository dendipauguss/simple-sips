<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan')->onDelete('cascade');
            $table->foreignId('pengenaan_sp_id')->constrained('pengenaan_sp')->onDelete('cascade');
            $table->bigInteger('pelaku_usaha_id')->nullable();
            $table->unsignedBigInteger('user_id')->default(0);
            $table->bigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('signature_jwt')->nullable();
            $table->string('approval_hash', 64)->nullable();
            $table->string('approval_ip', 45)->nullable();
            $table->text('approval_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_item');
    }
};
