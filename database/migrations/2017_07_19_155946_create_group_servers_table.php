<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_servers', function (Blueprint $table) {
            $table->integer('server_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->primary(array('server_id', 'group_id'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_servers');
    }
}
