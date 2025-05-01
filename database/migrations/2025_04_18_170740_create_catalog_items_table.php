<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('catalog_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalog_id')->constrained();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained(table: 'catalog_items', indexName: 'parent_idx');
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
