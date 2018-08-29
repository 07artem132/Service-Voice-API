<?php

namespace Api\Task;

use Api\TeamspeakInstances;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Jobs\TeamSpeakVirtualServerStatisticsCollections;

/**
 * Class TeamSpeakVirtualServersStatisticsCollectionsTask
 * @package Api\Task
 */
class TeamSpeakVirtualServersStatisticsCollectionsTask {
	/**
	 * @var teamSpeak класс для взаимодействия с teamspeak 3
	 */
	private $ts3con;

	function CronCallback() {
		$servers = TeamspeakInstances::Active()->get();

		foreach ( $servers as $server ) {
			TeamSpeakVirtualServerStatisticsCollections::dispatch( $server->id );
		}
	}
}