<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 512)->nullable();
            $table->string('slug');
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalogs');
    }
};
