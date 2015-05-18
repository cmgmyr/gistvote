<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gists', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id');
            $table->string('file');
            $table->text('description')->nullable();
            $table->boolean('public');
            $table->integer('files');
            $table->integer('comments');
            $table->timestamps();
            $table->dateTime('last_scan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gists');
    }
}
