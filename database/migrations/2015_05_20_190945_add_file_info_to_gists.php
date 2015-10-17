<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFileInfoToGists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gists', function (Blueprint $table) {
            $table->string('file_language')->after('file')->nullable();
            $table->text('file_content')->after('file_language')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gists', function (Blueprint $table) {
            $table->dropColumn(['file_language', 'file_content']);
        });
    }
}
