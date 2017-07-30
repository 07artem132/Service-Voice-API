<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\UserTeamSpeakVirtualServer
 *
 * @mixin \Eloquent
 * @property-read \Api\TeamspeakInstances $instance
 * @property-read \Api\User $user
 */
class UserTeamSpeakVirtualServer extends Model
{
    public function instance()
    {
        return $this->belongsTo('Api\TeamspeakInstances', 'id', 'instance_id');
    }

    public function user()
    {
        return $this->belongsTo('Api\User', 'id', 'user_id');
    }
}
