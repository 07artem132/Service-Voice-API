<?php

namespace Api\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Api\Services\TeamSpeak3\TeamSpeak;
use Illuminate\Queue\InteractsWithQueue;
use Api\SnapshotsTeamspeakVirtualServers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TeamSpeakVirtualServerCreateSnapshot implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	private $instance_id;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct( $instance_id ) {
		$this->instance_id = $instance_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		$ts3con = new TeamSpeak( $this->instance_id );
		try {
			foreach ( $ts3con->ReturnConnection()->serverList() as $VirtualServer ) {
				if ( (string) $VirtualServer['virtualserver_status'] != 'online' && ! config( 'TeamSpeakVirtualServerCreateSnapshotTask.CreateSnapshotsDisabledVirtualServers' ) ) {
					continue;
				}
				$db              = new SnapshotsTeamspeakVirtualServers;
				$db->instance_id = $this->instance_id;
				$db->unique_id   = $VirtualServer['virtualserver_unique_identifier'];
				$db->snapshot    = $VirtualServer->snapshotCreate();
				$db->save();
			}
		} catch ( \Exception $e ) {
			if ( $e->getMessage() === 'database empty result set' ) {
				$ts3con->logout();

				return;
			}
		}
		$ts3con->logout();
	}
}
