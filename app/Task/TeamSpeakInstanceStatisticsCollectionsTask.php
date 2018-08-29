<?php

namespace Api\Task;

use Api\TeamspeakInstances;
use Api\Jobs\TeamSpeakInstanceStatisticsCollections;

/**
 * Class TeamSpeakInstanceStatisticsCollectionsTask
 * @package Api\Task
 */
class TeamSpeakInstanceStatisticsCollectionsTask {

	function CronCallback() {
		$servers = TeamspeakInstances::Active()->get();

		foreach ( $servers as $server ) {
			TeamSpeakInstanceStatisticsCollections::dispatch( $server->id );
		}
	}

}