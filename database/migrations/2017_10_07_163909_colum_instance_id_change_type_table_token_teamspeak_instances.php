<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumInstanceIdChangeTypeTableTokenTeamspeakInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('token_teamspeak_instances', function (Blueprint $table) {
            $table->smallInteger('instance_id')->unsigned()->change();
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
            $table->integer('instance_id')->change();
        });
    }
}
