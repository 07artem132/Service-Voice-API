<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableStatisticsTeamspeakInstancesAddIndexColumInstanceId extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'statistics_teamspeak_instances', function ( Blueprint $table ) {
			$table->index( [  'instance_id' ] );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'statistics_teamspeak_instances', function ( Blueprint $table ) {
			$table->dropIndex( 'instance_id' );
		} );
	}
}
