<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSnapshotsVirtualServersRenameToSnapshotsTeamspeakVirtualServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('snapshots_virtual_servers', 'snapshots_teamspeak_virtual_servers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('snapshots_teamspeak_virtual_servers', 'snapshots_virtual_servers');
    }
}
