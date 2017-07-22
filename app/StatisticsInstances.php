<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Api\StatisticsInstances
 *
 * @property int $id
 * @property int $server_id
 * @property int $slot_usage
 * @property int $server_runing
 * @property int $user_online
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances dayAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances fiveMinutesAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances halfHourAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances hourAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances serverID($server_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances statDay()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances statMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances statRealtime()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances statWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances statYear()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances whereServerRuning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances whereSlotUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsInstances whereUserOnline($value)
 * @mixin \Eloquent
 */
class StatisticsInstances extends Model
{
    protected $hidden = ['id', 'updated_at', 'server_id'];

    public function scopeServerID($query, $server_id)
    {
        return $query->where('server_id', $server_id);
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
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at'))
            ->groupBy(DB::raw('floor((unix_timestamp(created_at))/300 ),hour(created_at)'));
    }

    function scopeHalfHourAvage($query)
    {
        return $query
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at'))
            ->groupBy(DB::raw('FLOOR((UNIX_TIMESTAMP(created_at) - 1800) / 3600),hour(created_at)'));
    }

    public function scopeHourAvage($query)
    {
        return $query
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at'))
            ->groupBy(DB::raw('DAY(created_at),HOUR(created_at)'));
    }

    public function scopeDayAvage($query)
    {
        return $query
            ->select(DB::raw('avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at'))
            ->groupBy(DB::raw('MONTH(created_at), DAYOFMONTH(created_at)'));
    }
}
