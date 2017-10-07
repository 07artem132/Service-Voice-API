<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumPortTableSnapshotsTeamspeakVirtualServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snapshots_teamspeak_virtual_servers', function (Blueprint $table) {
            $table->dropColumn('port');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snapshots_teamspeak_virtual_servers', function (Blueprint $table) {
            $table->string('port')->after('unique_id')->nullable();
        });
    }
}