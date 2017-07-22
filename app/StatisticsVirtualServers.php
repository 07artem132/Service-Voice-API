<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Api\StatisticsVirtualServers
 *
 * @property int $id
 * @property int $server_id
 * @property string $unique_id
 * @property int $user_online
 * @property int $slot_usage
 * @property float $avg_ping
 * @property float $avg_packetloss
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers dayAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers fiveMinutesAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers halfHourAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers hourAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers serverID($server_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers statDay()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers statMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers statRealtime()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers statWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers statYear()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers virtualServerUID($unique_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereAvgPacketloss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereAvgPing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereSlotUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsVirtualServers whereUserOnline($value)
 * @mixin \Eloquent
 */
class StatisticsVirtualServers extends Model
{
    protected $hidden = ['id', 'updated_at', 'server_id', 'unique_id'];

    public function scopeServerID($query, $server_id)
    {
        return $query->where('server_id', $server_id);
    }

    public function scopeVirtualServerUID($query, $unique_id)
    {
        return $query->where('unique_id', $unique_id);
    }

    public function scopeStatYear($query)
    {
        return $query->whereBetween('created_at', [date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1)), date("Y-m-d H:i:s")]);
    }

    public function scopeStatMonth($query)
    {
        return $query->whereBetween('created_at', [date("Y-m-d H:i:s", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))), date("Y-m-d H:i:s")]);
    }

    function scopeStatWeek($query)
    {
        return $query->whereBetween('created_at', [date("Y-m-d H:i:s", time() - 7 * 24 * 60 * 60), date("Y-m-d H:i:s")]);
    }

    function scopeStatDay($query)
    {
        return $query->whereBetween('created_at', [date("Y-m-d H:i:s", time() - 24 * 60 * 60), date("Y-m-d H:i:s")]);
    }

    function scopeStatRealtime($query)
    {
        return $query->whereBetween('created_at', [date("Y-m-d H:i:s", time() - 60 * 60), date("Y-m-d H:i:s")]);
    }

    function scopeFiveMinutesAvage($query)
    {
        return $query
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(user_online) as user_online,avg(avg_ping) as avg_ping,avg(avg_packetloss) as avg_packetloss,created_at'))
            ->groupBy(DB::raw('floor((unix_timestamp(created_at))/300 ),hour(created_at)'));
    }

    function scopeHalfHourAvage($query)
    {
        return $query
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(user_online) as user_online,avg(avg_ping) as avg_ping,avg(avg_packetloss) as avg_packetloss,created_at'))
            ->groupBy(DB::raw('FLOOR((UNIX_TIMESTAMP(created_at) - 1800) / 3600),hour(created_at)'));
    }

    public function scopeHourAvage($query)
    {
        return $query
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(user_online) as user_online,avg(avg_ping) as avg_ping,avg(avg_packetloss) as avg_packetloss,created_at'))
            ->groupBy(DB::raw('DAY(created_at),HOUR(created_at)'));
    }

    public function scopeDayAvage($query)
    {
        return $query
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(user_online) as user_online,avg(avg_ping) as avg_ping,avg(avg_packetloss) as avg_packetloss,created_at'))
            ->groupBy(DB::raw('MONTH(created_at), DAYOFMONTH(created_at)'));
    }

}
