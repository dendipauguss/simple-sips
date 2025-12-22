<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->bigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('signature_jwt')->nullable();
            $table->string('approval_hash', 64)->nullable();
            $table->string('approval_ip', 45)->nullable();
            $table->text('approval_agent')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['approved_by', 'approved_at', 'signature_jwt', 'approval_hash', 'approval_ip', 'approval_agent']);
        });
    }
};
