<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->integer('foreign_key');
            $table->string('name');
            $table->string('type');
            $table->integer('size');
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->timestamps();
            $table->index(['model', 'foreign_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
