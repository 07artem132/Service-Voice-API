<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 07.10.2017
 * Time: 18:28
 */

namespace Api\Task;

use Cache;
use Redis;
use Carbon\Carbon;
use Api\TeamspeakInstances;
use Api\StatisticsTeamspeakInstances;

/**
 * Class TeamSpeakStatisticsInstancesCacheUpdate
 * @package Api\Task
 */
class TeamSpeakStatisticsInstancesCacheUpdate
{
    function CronCallback()
    {
        $servers = TeamspeakInstances::Active()->get();

        foreach ($servers as $server) {
            $this->CacheUpdate($server->id);
        }
    }

    function CacheUpdate($instance_id)
    {
        $this->CacheRealtime($instance_id);
        $this->CacheDay($instance_id);
        $this->CacheWeek($instance_id);
        $this->CacheMonth($instance_id);
        $this->CacheYear($instance_id);
    }

    function CacheYear($instance_id)
    {
        if (Cache::has('InstanseStatisticsYearServerID-' . $instance_id)) {
            if (Redis::command('TTL', [Cache::getPrefix() . 'InstanseStatisticsYearServerID-' . $instance_id]) < 10) {
                $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Year'));
                $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatYear()->DayAvage()->get();
                Cache::put('InstanseStatisticsYearServerID-' . $instance_id, $data, $minutes);
            }
        } else {
            $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Year'));
            $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatYear()->DayAvage()->get();
            Cache::put('InstanseStatisticsYearServerID-' . $instance_id, $data, $minutes);
        }
    }

    function CacheMonth($instance_id)
    {
        if (Cache::has('InstanseStatisticsMonthServerID-' . $instance_id)) {
            if (Redis::command('TTL', [Cache::getPrefix() . 'InstanseStatisticsMonthServerID-' . $instance_id]) < 10) {
                $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Month'));
                $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatMonth()->HourAvage()->get();
                Cache::put('InstanseStatisticsMonthServerID-' . $instance_id, $data, $minutes);
            }
        } else {
            $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Month'));
            $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatMonth()->HourAvage()->get();
            Cache::put('InstanseStatisticsMonthServerID-' . $instance_id, $data, $minutes);
        }
    }

    function CacheWeek($instance_id)
    {
        if (Cache::has('InstanseStatisticsWeekServerID-' . $instance_id)) {
            if (Redis::command('TTL', [Cache::getPrefix() . 'InstanseStatisticsWeekServerID-' . $instance_id]) < 10) {
                $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Week'));
                $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatWeek()->HalfHourAvage()->get();
                Cache::put('InstanseStatisticsWeekServerID-' . $instance_id, $data, $minutes);
            }
        } else {
            $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Week'));
            $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatWeek()->HalfHourAvage()->get();
            Cache::put('InstanseStatisticsWeekServerID-' . $instance_id, $data, $minutes);
        }
    }

    function CacheDay($instance_id)
    {
        if (Cache::has('InstanseStatisticsDayServerID-' . $instance_id)) {
            if (Redis::command('TTL', [Cache::getPrefix() . 'InstanseStatisticsDayServerID-' . $instance_id]) < 10) {
                $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Day'));
                $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatDay()->FiveMinutesAvage()->get();
                Cache::put('InstanseStatisticsDayServerID-' . $instance_id, $data, $minutes);
            }
        } else {
            $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Day'));
            $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatDay()->FiveMinutesAvage()->get();
            Cache::put('InstanseStatisticsDayServerID-' . $instance_id, $data, $minutes);
        }
    }

    function CacheRealtime($instance_id)
    {
        if (Cache::has('InstanseStatisticsRealtimeServerID-' . $instance_id)) {
            if (Redis::command('TTL', [Cache::getPrefix() . 'InstanseStatisticsRealtimeServerID-' . $instance_id]) < 10) {
                $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Realtime'));
                $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatRealtime()->get();
                Cache::put('InstanseStatisticsRealtimeServerID-' . $instance_id, $data, $minutes);
            }
        } else {
            $minutes = Carbon::now()->addMinutes(config('ApiCache.TeamSpeak.Statistics.Instanse.Realtime'));
            $data = StatisticsTeamspeakInstances::InstanceId($instance_id)->StatRealtime()->get();
            Cache::put('InstanseStatisticsRealtimeServerID-' . $instance_id, $data, $minutes);
        }
    }
}