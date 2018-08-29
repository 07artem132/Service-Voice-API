<?php

namespace Api\Jobs;

use Illuminate\Bus\Queueable;
use Api\StatisticsTeamspeakInstances;
use Api\Services\TeamSpeak3\TeamSpeak;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TeamSpeakInstanceStatisticsCollections implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $instance_id, $ts3con;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct( int $instance_id ) {
		$this->instance_id = $instance_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		$ts3con = new TeamSpeak( $this->instance_id );

		$hostinfo = $ts3con->hostinfo();
		$ts3con->logout();

		$db                = new StatisticsTeamspeakInstances;
		$db->instance_id   = $this->instance_id;
		$db->slot_usage    = (int) $hostinfo[0]['virtualservers_total_maxclients'];
		$db->server_runing = (int) $hostinfo[0]['virtualservers_running_total'];
		$db->user_online   = (int) $hostinfo[0]['virtualservers_total_clients_online'];
		$db->save();
	}
}
