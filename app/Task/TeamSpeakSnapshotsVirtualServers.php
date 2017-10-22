<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 28.06.2017
 * Time: 18:04
 */

namespace Api\Task;

use Api\TeamspeakInstances;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\SnapshotsTeamspeakVirtualServers;

/**
 * Class TeamSpeakSnapshotsVirtualServers
 * @package Api\Task
 */
class TeamSpeakSnapshotsVirtualServers {
	/**
	 * @var teamSpeak класс для взаимодействия с teamspeak 3
	 */
	private $ts3con;
	private $KeepDays;
	private $CreateDisabledServers;

	public function __construct() {
		$this->KeepDays              = config( 'TeamSpeakSnapshotsVirtualServers.KeepDays' );
		$this->CreateDisabledServers = config( 'TeamSpeakSnapshotsVirtualServers.CreateSnapshotsDisabledVirtualServers' );
	}

	function CronCallback() {
		$servers = TeamspeakInstances::Active()->get();

		foreach ( $servers as $server ) {
			$this->CreateSnapshots( $server->id );
		}

		$this->RemoveOldSnapshots();
	}

	/**
	 * @param int $instance_id уникальный идентификатор teamspeak 3 инстанса
	 */
	public function CreateSnapshots( int $instance_id ): void {
		$this->ts3con = new TeamSpeak( $instance_id );
		$data         = $this->GetAllServersSnapshots();

		if ( ! empty( $data ) ) {
			foreach ( $data as $VirtualServerSnapshots ) {
				$db              = new SnapshotsTeamspeakVirtualServers;
				$db->instance_id = $instance_id;
				$db->unique_id   = $VirtualServerSnapshots['unique_id'];
				$db->snapshot    = $VirtualServerSnapshots['snapshot'];
				$db->save();
			}
		}

		$this->ts3con->logout();

		return;
	}

	/**
	 * @return array набор данных подготовленных для сохранения в базу данных.
	 */
	function GetAllServersSnapshots(): ?array {
		foreach ( $this->ts3con->ReturnConnection() as $VirtualServer ) {
			if ( (string) $VirtualServer['virtualserver_status'] != 'online' && ! $this->CreateDisabledServers ) {
				continue;
			}

			$data[ $VirtualServer['virtualserver_id'] ]['unique_id'] = (string) $VirtualServer['virtualserver_unique_identifier'];
			$data[ $VirtualServer['virtualserver_id'] ]['snapshot']  = (string) $VirtualServer->snapshotCreate();
		}

		return $data;
	}

	function RemoveOldSnapshots(): void {
		SnapshotsTeamspeakVirtualServers::GetOlder( $this->KeepDays )->delete();

		return;
	}
}