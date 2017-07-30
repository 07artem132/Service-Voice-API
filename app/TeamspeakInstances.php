<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\TeamspeakInstances
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances teamSpeak()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereIpaddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TeamspeakInstances whereUsername($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\SnapshotsTeamspeakVirtualServers[] $snapshots
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\StatisticsTeamspeakInstances[] $statisticsInstances
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\StatisticsTeamspeakVirtualServers[] $statisticsVirtualServers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\TokenTeamspeakInstances[] $tokenTeamSpeakInstances
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\TokenTeamspeakVirtualServers[] $tokenTeamSpeakVirtualServers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\UserTeamspeakInstances[] $userTeamSpeakInstances
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\UserTeamSpeakVirtualServer[] $userTeamSpeakVirtualServers
 */
class TeamspeakInstances extends Model
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

    public function snapshots()
    {
        return $this->hasMany('Api\SnapshotsTeamspeakVirtualServers', 'instance_id', 'id');
    }

    public function statisticsInstances()
    {
        return $this->hasMany('Api\StatisticsTeamspeakInstances', 'instance_id', 'id');
    }

    public function statisticsVirtualServers()
    {
        return $this->hasMany('Api\StatisticsTeamspeakVirtualServers', 'instance_id', 'id');
    }

    public function tokenTeamSpeakInstances()
    {
        return $this->hasMany('Api\TokenTeamspeakInstances', 'instance_id', 'id');
    }

    public function tokenTeamSpeakVirtualServers()
    {
        return $this->hasMany('Api\TokenTeamspeakVirtualServers', 'instance_id', 'id');
    }

    public function userTeamSpeakInstances()
    {
        return $this->hasMany('Api\UserTeamspeakInstances', 'instance_id', 'id');
    }

    public function userTeamSpeakVirtualServers()
    {
        return $this->hasMany('Api\UserTeamSpeakVirtualServer', 'instance_id', 'id');
    }


}
