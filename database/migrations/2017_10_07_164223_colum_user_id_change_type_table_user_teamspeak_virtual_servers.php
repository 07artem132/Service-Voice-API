<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumUserIdChangeTypeTableUserTeamspeakVirtualServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_teamspeak_virtual_servers', function (Blueprint $table) {
            $table->smallInteger('user_id')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_teamspeak_virtual_servers', function (Blueprint $table) {
            $table->integer('user_id')->change();
        });
    }
}
