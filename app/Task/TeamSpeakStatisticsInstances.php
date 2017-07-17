<?php

namespace Api\Task;

use Api\Services\TeamSpeak3\ts3query;
use Api\StatisticsInstances;
use Api\Servers;

class TeamSpeakStatisticsInstances
{
    private $ts3con;

    function __construct()
    {
        $servers = Servers::Active()->TeamSpeak()->get();

        foreach ($servers as $server) {
            $this->CollectionStatistics($server->id);
        }
    }

    public function CollectionStatistics($server_id)
    {
        $this->ts3con = new ts3query($server_id);
        $db = new StatisticsInstances;
        $db->server_id = $server_id;
        $db->slot_usage = $this->GetSlotUsage();
        $db->server_runing = $this->GetRuningVirtualServer();
        $db->user_online = $this->GetUserOnline();
        $db->save();

        $this->ts3con->logout();

        return null;
    }

    private function GetSlotUsage()
    {
        return $this->ts3con->hostinfo()[0]['virtualservers_total_maxclients'];
    }

    private function GetRuningVirtualServer()
    {
        return $this->ts3con->hostinfo()[0]['virtualservers_running_total'];
    }

    private function GetUserOnline()
    {
        return $this->ts3con->hostinfo()[0]['virtualservers_total_clients_online'];
    }
}