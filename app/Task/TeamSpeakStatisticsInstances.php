<?php

namespace Api\Task;

use Api\Servers;
use Api\StatisticsInstances;
use Api\Services\TeamSpeak3\ts3query;

/**
 * Class TeamSpeakStatisticsInstances
 * @package Api\Task
 */
class TeamSpeakStatisticsInstances
{
    /**
     * @var ts3query класс для взаимодействия с teamspeak 3
     */
    private $ts3con;

    function CronCallback()
    {
        $servers = Servers::Active()->TeamSpeak()->get();

        foreach ($servers as $server) {
            $this->CollectionStatistics($server->id);
        }
    }

    /**
     * @param $server_id
     * @return null
     */
    public function CollectionStatistics($server_id): void
    {
        $this->ts3con = new ts3query($server_id);
        $db = new StatisticsInstances;
        $db->server_id = $server_id;
        $db->slot_usage = $this->GetSlotUsage();
        $db->server_runing = $this->GetRuningVirtualServer();
        $db->user_online = $this->GetUserOnline();
        $db->save();

        $this->ts3con->logout();

        return;
    }

    /**
     * @return int кол-во слотов используемых инстансом
     */
    private function GetSlotUsage(): int
    {
        return (int)$this->ts3con->hostinfo()[0]['virtualservers_total_maxclients'];
    }

    /**
     * @return int кол-во запушенных виртуальных серверов
     */
    private function GetRuningVirtualServer(): int
    {
        return (int)$this->ts3con->hostinfo()[0]['virtualservers_running_total'];
    }

    /**
     * @return int кол-во пользователей онлайн
     */
    private function GetUserOnline(): int
    {
        return (int)$this->ts3con->hostinfo()[0]['virtualservers_total_clients_online'];
    }
}