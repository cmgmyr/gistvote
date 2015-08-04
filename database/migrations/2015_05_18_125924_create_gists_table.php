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
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->boolean('public')->default(false);
            $table->integer('files')->default(0);
            $table->integer('comments')->default(0);
            $table->nullableTimestamps();
            $table->dateTime('last_scan')->nullable();
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
