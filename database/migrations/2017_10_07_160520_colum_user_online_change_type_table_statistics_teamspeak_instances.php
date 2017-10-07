<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumUserOnlineChangeTypeTableStatisticsTeamspeakInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistics_teamspeak_instances', function (Blueprint $table) {
            $table->smallInteger('user_online')->unsigned()->change();
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
            $table->integer('user_online')->unsigned()->change();
        });
    }
}
