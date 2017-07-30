<?php

namespace Api\Task;

use Api\TeamspeakInstances;
use Api\StatisticsTeamspeakInstances;
use Api\Services\TeamSpeak3\TeamSpeak;

/**
 * Class TeamSpeakStatisticsInstances
 * @package Api\Task
 */
class TeamSpeakStatisticsInstances
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
     * @param $instance_id уникальный идентификатор teamspeak 3 инстанса
     * @return null
     */
    public function CollectionStatistics(int $instance_id): void
    {
        $this->ts3con = new TeamSpeak($instance_id);
        $db = new StatisticsTeamspeakInstances;
        $db->instance_id = $instance_id;
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