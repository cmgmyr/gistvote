<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddVotingEnabledToGistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gists', function (Blueprint $table) {
            $table->boolean('enable_voting')->default(false)->after('comments');
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
            $table->dropColumn('enable_voting');
        });
    }
}
