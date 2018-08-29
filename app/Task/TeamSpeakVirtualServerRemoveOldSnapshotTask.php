<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 01.02.2018
 * Time: 20:20
 */

namespace Api\Task;

use Api\SnapshotsTeamspeakVirtualServers;

class TeamSpeakVirtualServerRemoveOldSnapshotTask {

	function CronCallback() {
		SnapshotsTeamspeakVirtualServers::GetOlder( config( 'TeamSpeakVirtualServerCreateSnapshotTask.KeepDays' ) )->delete();
	}
}