<?php

namespace Api\Task;

use Api\Services\TeamSpeak3\ts3query;
use Api\Servers;
use Api\StatisticsVirtualServers;

class TeamSpeakStatisticsVirtualServersInstance
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
        $data = $this->ts3con->GetAllServerStatisticsInfo();
        foreach ($data as $VirtualServer) {
            $db = new StatisticsVirtualServers;
            $db->server_id = $server_id;
            $db->unique_id = $VirtualServer['unique_id'];
            $db->user_online = $VirtualServer['user_online'];
            $db->slot_usage = $VirtualServer['slot_usage'];
            $db->avg_ping = $VirtualServer['avg_ping'];
            $db->avg_packetloss = $VirtualServer['avg_packetloss'];
            $db->save();
        }

        $this->ts3con->logout();

        return null;
    }

}