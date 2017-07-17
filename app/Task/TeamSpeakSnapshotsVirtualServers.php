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

class TeamSpeakSnapshotsVirtualServers
{
    private $ts3con;

    function __construct()
    {
        $servers = Servers::Active()->TeamSpeak()->get();

        foreach ($servers as $server) {
            $this->CreateSnapshots($server->id);
        }
    }

    public function CreateSnapshots($server_id)
    {
        $this->ts3con = new ts3query($server_id);
        $data = $this->ts3con->GetAllServersSnapshots();
        foreach ($data as $VirtualServerSnapshots) {
            $db = new SnapshotsVirtualServers;
            $db->server_id = $server_id;
            $db->unique_id = $VirtualServerSnapshots['unique_id'];
            $db->snapshot = $VirtualServerSnapshots['snapshot'];
            $db->save();
        }

        $this->ts3con->logout();

        return null;
    }
}