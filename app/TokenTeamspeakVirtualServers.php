<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Api\TokenTeamspeakVirtualServers
 *
 * @property int $id
 * @property int $token_id
 * @property int $instance_id
 * @property string $unique_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Api\TeamspeakInstances $instance
 * @property-read \Api\UserToken $token
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenTeamspeakVirtualServers onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakVirtualServers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakVirtualServers whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakVirtualServers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakVirtualServers whereInstanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakVirtualServers whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakVirtualServers whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakVirtualServers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenTeamspeakVirtualServers withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenTeamspeakVirtualServers withoutTrashed()
 * @mixin \Eloquent
 */
class TokenTeamspeakVirtualServers extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['id', 'token_id','updated_at','deleted_at'];

    public function token()
    {
        return $this->belongsTo('Api\UserToken', 'id', 'token_id');
    }

    public function instance()
    {
        return $this->belongsTo('Api\TeamspeakInstances', 'id', 'instance_id');
    }

}
