<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerintahsanksiTable extends Migration
{
    public function up()
    {
        Schema::create('perintahsanksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('sanksi_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perintahsanksi');
    }
}
