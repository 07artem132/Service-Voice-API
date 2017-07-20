<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeKeyBlockSizeSnapshotsVirtualServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE snapshots_virtual_servers  KEY_BLOCK_SIZE = 1 , ROW_FORMAT = COMPRESSED');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE snapshots_virtual_servers ROW_FORMAT=COMPACT;');
    }
}
