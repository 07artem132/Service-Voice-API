<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 28.06.2017
 * Time: 18:04
 */

namespace Api\Task;

use Api\Jobs\TeamSpeakVirtualServerCreateSnapshot;
use Api\TeamspeakInstances;
use Api\Services\TeamSpeak3\TeamSpeak;

/**
 * Class TeamSpeakVirtualServerCreateSnapshotTask
 * @package Api\Task
 */
class TeamSpeakVirtualServerCreateSnapshotTask {

	function CronCallback() {
		$servers = TeamspeakInstances::Active()->get();

		foreach ( $servers as $server ) {
			TeamSpeakVirtualServerCreateSnapshot::dispatch( $server->id );
		}
	}
}