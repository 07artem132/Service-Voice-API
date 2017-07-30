<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\UserTeamspeakInstances
 *
 * @property int $id
 * @property string $user_id
 * @property string $server_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserTeamspeakInstances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserTeamspeakInstances whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserTeamspeakInstances whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserTeamspeakInstances whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserTeamspeakInstances whereUserId($value)
 * @mixin \Eloquent
 */
class UserTeamspeakInstances extends Model
{
    public function instance()
    {
        return $this->belongsTo('Api\TeamSpeakInstances', 'id', 'instance_id');
    }

}
