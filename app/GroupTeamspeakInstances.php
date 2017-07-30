<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\GroupTeamspeakInstances
 *
 * @property int $server_id
 * @property int $group_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances server($server_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupTeamspeakInstances extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeServer($query, $server_id)
    {
        $query->where('server_id', '=', $server_id);
    }

    public function group()
    {
        return $this->belongsTo('Api\Group', 'id','group_id');
    }

    public function instance()
    {
        return $this->hasOne('Api\TeamspeakInstances','id','instance_id');
    }


}
