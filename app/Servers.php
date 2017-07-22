<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\Servers
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $ipaddress
 * @property string $hostname
 * @property string $username
 * @property string $password
 * @property int $port
 * @property int $is_enabled
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers teamSpeak()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereIpaddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\Servers whereUsername($value)
 * @mixin \Eloquent
 */
class Servers extends Model
{
    /**
     * Заготовка запроса для получения активных teamspeak 3 серверов.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_enabled', 1);
    }

    /**
     * Заготовка запроса для получения teamspeak 3 серверов.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTeamSpeak($query)
    {
        return $query->where('type', '=', 'teamspeak');
    }
}
