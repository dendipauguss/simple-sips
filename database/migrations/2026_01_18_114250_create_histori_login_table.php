<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histori_login', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('name');
            $table->string('provider')->nullable(); // google / password
            $table->timestamp('last_login_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histori_login');
    }
};
