<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumTokenIdChangeTypeTableTokenTeamspeakInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('token_teamspeak_instances', function (Blueprint $table) {
            $table->smallInteger('token_id')->unsigned()->change();
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
            $table->integer('token_id')->change();
        });
    }
}
