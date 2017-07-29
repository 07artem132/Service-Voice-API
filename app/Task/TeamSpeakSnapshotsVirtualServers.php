<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 28.06.2017
 * Time: 18:04
 */

namespace Api\Task;

use Api\SnapshotsVirtualServers;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Servers;

/**
 * Class TeamSpeakSnapshotsVirtualServers
 * @package Api\Task
 */
class TeamSpeakSnapshotsVirtualServers
{
    /**
     * @var teamSpeak класс для взаимодействия с teamspeak 3
     */
    private $ts3con;

    function CronCallback()
    {
        $servers = Servers::Active()->TeamSpeak()->get();

        foreach ($servers as $server) {
            $this->CreateSnapshots($server->id);
        }
    }

    /**
     * @param int $server_id уникальный идентификатор сервера
     */
    public function CreateSnapshots(int $server_id): void
    {
        $this->ts3con = new TeamSpeak($server_id);
        $data = $this->GetAllServersSnapshots();
        foreach ($data as $VirtualServerSnapshots) {
            $db = new SnapshotsVirtualServers;
            $db->server_id = $server_id;
            $db->unique_id = $VirtualServerSnapshots['unique_id'];
            $db->port = $VirtualServerSnapshots['port'];
            $db->snapshot = $VirtualServerSnapshots['snapshot'];
            $db->save();
        }

        $this->ts3con->logout();

        return;
    }

    /**
     * @return array набор данных подготовленных для сохранения в базу данных.
     */
    function GetAllServersSnapshots(): array
    {
        $data = [];
        foreach ($this->ts3con->ReturnConnection() as $VirtualServer) {
            $data[$VirtualServer['virtualserver_id']]['port'] = (int)$VirtualServer['virtualserver_port'];
            $data[$VirtualServer['virtualserver_id']]['unique_id'] = (string)$VirtualServer['virtualserver_unique_identifier'];
            $data[$VirtualServer['virtualserver_id']]['snapshot'] = (string)$VirtualServer->snapshotCreate();
        }

        return $data;
    }

}