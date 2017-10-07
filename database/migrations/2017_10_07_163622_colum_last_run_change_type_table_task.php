<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumLastRunChangeTypeTableTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('last_run');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamp('last_run');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('last_run');

        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('last_run');
        });
    }
}
