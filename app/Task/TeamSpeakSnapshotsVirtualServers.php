<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 28.06.2017
 * Time: 18:04
 */

namespace Api\Task;

use Api\SnapshotsVirtualServers;
use Api\Services\TeamSpeak3\ts3query;
use Api\Servers;

/**
 * Class TeamSpeakSnapshotsVirtualServers
 * @package Api\Task
 */
class TeamSpeakSnapshotsVirtualServers
{
    /**
     * @var ts3query класс для взаимодействия с teamspeak 3
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
        $this->ts3con = new ts3query($server_id);
        $data = $this->ts3con->GetAllServersSnapshots();
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
}