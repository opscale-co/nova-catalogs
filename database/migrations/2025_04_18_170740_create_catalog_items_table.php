<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('catalog_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('catalog_id')->constrained();
            $table->string('name');
            $table->string('key');
            $table->json('metadata')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_items');
    }
};
