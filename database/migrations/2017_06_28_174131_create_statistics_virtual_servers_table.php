<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsVirtualServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics_virtual_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id');
            $table->string('unique_id');
            $table->integer('user_online');
            $table->integer('slot_usage');
            $table->float('avg_ping');
            $table->float('avg_packetloss');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics_virtual_servers');
    }
}
