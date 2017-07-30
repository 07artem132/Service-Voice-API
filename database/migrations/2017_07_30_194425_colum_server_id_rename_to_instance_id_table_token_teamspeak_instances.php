<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumServerIdRenameToInstanceIdTableTokenTeamspeakInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('token_teamspeak_instances', function (Blueprint $table) {
            $table->renameColumn('server_id', 'instance_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('token_teamspeak_instances', function (Blueprint $table) {
            $table->renameColumn('instance_id', 'server_id');
        });
    }
}
