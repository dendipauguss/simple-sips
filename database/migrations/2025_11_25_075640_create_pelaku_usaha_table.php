<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelakuUsahaTable extends Migration
{
    public function up()
    {
        Schema::create('pelaku_usaha', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('jenis_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaku_usaha');
    }
}
