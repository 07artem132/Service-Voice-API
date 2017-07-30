<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableStatisticsVirtualServersRenameToStatisticsTeamspeakVirtualServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('statistics_virtual_servers', 'statistics_teamspeak_virtual_servers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('statistics_teamspeak_virtual_servers', 'statistics_virtual_servers');
    }
}
