<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCommentCheckToGistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gists', function (Blueprint $table) {
            $table->boolean('has_powered_by')->default(false)->after('enable_voting');
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
            $table->dropColumn('has_powered_by');
        });
    }
}
