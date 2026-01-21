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
            $table->text('description')->nullable();
            $table->json('data')->nullable();

            $table->unique(['catalog_id', 'key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_items');
    }
};
