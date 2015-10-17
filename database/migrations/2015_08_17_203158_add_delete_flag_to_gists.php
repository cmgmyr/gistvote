<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeleteFlagToGists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gists', function (Blueprint $table) {
            $table->boolean('should_delete')->default(false)->after('has_powered_by');
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
            $table->dropColumn('should_delete');
        });
    }
}
