<?php

namespace Api\Task;

use Api\Servers;
use Api\StatisticsVirtualServers;
use Api\Services\TeamSpeak3\ts3query;

/**
 * Class TeamSpeakStatisticsVirtualServersInstance
 * @package Api\Task
 */
class TeamSpeakStatisticsVirtualServersInstance
{
    /**
     * @var ts3query класс для взаимодействия с teamspeak 3
     */
    private $ts3con;

    /**
     * TeamSpeakStatisticsVirtualServersInstance constructor.
     */
    function __construct()
    {
        $servers = Servers::Active()->TeamSpeak()->get();

        foreach ($servers as $server) {
            $this->CollectionStatistics($server->id);
        }
    }

    /**
     * @param int $server_id
     */
    public function CollectionStatistics(int $server_id): void
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

        return;
    }

}