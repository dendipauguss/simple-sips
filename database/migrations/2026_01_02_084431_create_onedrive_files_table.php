<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onedrive_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_id')->nullable();
            $table->string('parent_folder_id')->nullable();
            $table->string('folder_id')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('web_url')->nullable();
            $table->text('download_url');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onedrive_files');
    }
};
