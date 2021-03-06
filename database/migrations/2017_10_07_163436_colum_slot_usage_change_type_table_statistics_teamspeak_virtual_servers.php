<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumSlotUsageChangeTypeTableStatisticsTeamspeakVirtualServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistics_teamspeak_virtual_servers', function (Blueprint $table) {
            $table->smallInteger('slot_usage')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statistics_teamspeak_virtual_servers', function (Blueprint $table) {
            $table->integer('slot_usage')->change();
        });
    }
}
