<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->timestamps();
        });

        Schema::create('items_images', function (Blueprint $table) {
            $table->integer('item_id');
            $table->integer('image_id');
            $table->integer('order');

            $table->foreign('item_id', 'items');
            $table->foreign('image_id', 'images');
        });

        Schema::create('news_images', function (Blueprint $table) {
            $table->integer('news_id');
            $table->integer('image_id');
            $table->string('source');

            $table->foreign('news_id', 'news');
            $table->foreign('image_id', 'images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('news');
        Schema::dropIfExists('images');
        Schema::dropIfExists('items_images');
        Schema::dropIfExists('news_images');
    }
}
