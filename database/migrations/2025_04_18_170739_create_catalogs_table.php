<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->nullableUlidMorphs('catalogable');
            $table->string('name');
            $table->string('key')->unique();
            $table->string('description', 512)->nullable();
            $table->json('metadata')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalogs');
    }
};
