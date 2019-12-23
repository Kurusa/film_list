<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->timestamp('release_date')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('producer_id')->unsigned()->nullable();
            $table->integer('budget')->unsigned()->nullable();
            $table->text('about')->nullable();
            $table->string('image')->nullable();
            $table->string('mime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('films');
    }
}
