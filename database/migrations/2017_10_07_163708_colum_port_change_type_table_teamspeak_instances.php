<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumPortChangeTypeTableTeamspeakInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teamspeak_instances', function (Blueprint $table) {
            $table->smallInteger('port')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teamspeak_instances', function (Blueprint $table) {
            $table->integer('port')->change();
        });
    }
}
