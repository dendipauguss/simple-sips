<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanksiTable extends Migration
{
    public function up()
    {
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sanksi');
    }
}
