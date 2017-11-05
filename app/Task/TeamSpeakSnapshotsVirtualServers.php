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
	private $instance_id;

	public function __construct() {
		$this->KeepDays              = config( 'TeamSpeakSnapshotsVirtualServers.KeepDays' );
		$this->CreateDisabledServers = config( 'TeamSpeakSnapshotsVirtualServers.CreateSnapshotsDisabledVirtualServers' );
	}

	function CronCallback() {


		$servers = TeamspeakInstances::Active()->get();

		if ( ini_set( "memory_limit", $servers->count() * 15000000 ) != true ) {
			throw  new \Exception( "Не удалось изменить memory_limit" );
		}

		foreach ( $servers as $server ) {
			$this->instance_id = $server->id;
			$this->CreateSnapshots();
		}

		$this->RemoveOldSnapshots();
	}

	/**
	 * @param int $instance_id уникальный идентификатор teamspeak 3 инстанса
	 */
	public function CreateSnapshots(): void {
		$this->ts3con = new TeamSpeak( $this->instance_id );

		$data = $this->GetAllServersSnapshots();

		if ( ! empty( $data ) ) {
			SnapshotsTeamspeakVirtualServers::insert( $data );
		}

		$this->ts3con->logout();
		unset( $this->ts3con, $data );
		gc_collect_cycles();
		gc_mem_caches();

		return;
	}

	/**
	 * @return array набор данных подготовленных для сохранения в базу данных.
	 */
	function GetAllServersSnapshots(): ?array {
		$i = 0;
		try {
			foreach ( $this->ts3con->ReturnConnection()->serverList() as $VirtualServer ) {
				if ( (string) $VirtualServer['virtualserver_status'] != 'online' && ! $this->CreateDisabledServers ) {
					continue;
				}

				$data[ $i ]['instance_id'] = $this->instance_id;
				$data[ $i ]['unique_id']   = (string) $VirtualServer['virtualserver_unique_identifier'];
				$data[ $i ]['snapshot']    = (string) $VirtualServer->snapshotCreate();
				$i ++;
			}
		} catch ( \Exception $e ) {
			if ( $e->getMessage() === 'database empty result set' ) {
				$this->ts3con->logout();

				return null;
			}
		}

		return $data;
	}

	function RemoveOldSnapshots(): void {
		SnapshotsTeamspeakVirtualServers::GetOlder( $this->KeepDays )->delete();

		return;
	}
}