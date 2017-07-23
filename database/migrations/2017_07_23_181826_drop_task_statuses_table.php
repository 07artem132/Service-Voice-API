<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('task_statuses');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->tinyInteger('in_progress');
            $table->timestamp('last_run')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('next_due')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }
}
