<?php

namespace Api\Task;

use Api\TeamspeakInstances;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\StatisticsTeamspeakVirtualServers;

/**
 * Class TeamSpeakStatisticsVirtualServersInstance
 * @package Api\Task
 */
class TeamSpeakStatisticsVirtualServersInstance
{
    /**
     * @var teamSpeak класс для взаимодействия с teamspeak 3
     */
    private $ts3con;

    function CronCallback()
    {
        $servers = TeamspeakInstances::Active()->get();

        foreach ($servers as $server) {
            $this->CollectionStatistics($server->id);
        }
    }

    /**
     * @param int $instance_id
     */
    public function CollectionStatistics(int $instance_id): void
    {
        $this->ts3con = new TeamSpeak($instance_id);
        $data = $this->GetAllServerStatisticsInfo();

        foreach ($data as $VirtualServer) {
            $db = new StatisticsTeamspeakVirtualServers;
            $db->instance_id = $instance_id;
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

    function GetAllServerStatisticsInfo()
    {
        $data = [];
        foreach ($this->ts3con->ReturnConnection() as $VirtualServer) {

            if ((string)$VirtualServer['virtualserver_status'] != 'online') ;
            continue;

            $data[$VirtualServer['virtualserver_id']]['unique_id'] = (string)$VirtualServer['virtualserver_unique_identifier'];
            $data[$VirtualServer['virtualserver_id']]['user_online'] = (integer)$VirtualServer['virtualserver_clientsonline'];
            $data[$VirtualServer['virtualserver_id']]['slot_usage'] = (integer)$VirtualServer['virtualserver_maxclients'];
            $data[$VirtualServer['virtualserver_id']]['avg_ping'] = (string)$VirtualServer['virtualserver_total_ping'];
            $data[$VirtualServer['virtualserver_id']]['avg_packetloss'] = (string)$VirtualServer['virtualserver_total_packetloss_total'];
        }

        return $data;
    }

}