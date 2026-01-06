<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onedrive_states', function (Blueprint $table) {
            $table->id();
            $table->text('token')->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('refresh_token')->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('token_obtained_time')->nullable();
            $table->integer('expires_in')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onedrive_states');
    }
};
