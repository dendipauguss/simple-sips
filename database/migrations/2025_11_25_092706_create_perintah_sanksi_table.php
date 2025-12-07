<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerintahSanksiTable extends Migration
{
    public function up()
    {
        Schema::create('perintah_sanksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('sanksi_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perintah_sanksi');
    }
}
