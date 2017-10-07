<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumServerRuningChangeTypeTableStatisticsTeamspeakInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistics_teamspeak_instances', function (Blueprint $table) {
            $table->smallInteger('server_runing')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statistics_teamspeak_instances', function (Blueprint $table) {
            $table->integer('server_runing')->unsigned()->change();
        });
    }
}
