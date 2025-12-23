<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan')->nullable();
            $table->integer('tahun')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status_persetujuan', ['setuju', 'pending', 'dikembalikan'])->default('pending');
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
        Schema::dropIfExists('laporan');
    }
};
