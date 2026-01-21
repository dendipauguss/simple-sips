<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->string('google_file_id', 100)->nullable();
            $table->string('google_file_path')->nullable();
            $table->uuid('file_token')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['google_file_id', 'google_file_path', 'file_token']);
        });
    }
};
