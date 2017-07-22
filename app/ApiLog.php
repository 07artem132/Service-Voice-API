<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Api\ApiLog
 *
 * @property int $id
 * @property string $token
 * @property string $method
 * @property string $execute_time
 * @property string $client_ip
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog dayAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog methodTop()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog statMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog statWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog token($token)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog whereClientIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog whereExecuteTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\ApiLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApiLog extends Model
{
    function scopeStatWeek($query)
    {
        return $query->whereBetween('created_at', [date("Y-m-d H:i:s", time() - 7 * 24 * 60 * 60), date("Y-m-d H:i:s")]);
    }

    function scopeToken($query, $token)
    {
        return $query->where('token', '=', $token);
    }

    public function scopeDayAvage($query)
    {
        return $query
            ->select(DB::raw('count(token) as request,DATE(created_at) as created_at'))
            ->groupBy(DB::raw('MONTH(created_at), DAYOFMONTH(created_at)'));
    }

    public function scopeStatMonth($query)
    {
        return $query->whereBetween('created_at', [date("Y-m-d H:i:s", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))), date("Y-m-d H:i:s")]);
    }

    public function scopeMethodTop($query)
    {
        return $query
            ->select(DB::raw('method,count(token) as request'))
            ->groupBy(DB::raw('method'));
    }
}
