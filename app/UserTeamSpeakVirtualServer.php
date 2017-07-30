<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\UserTeamSpeakVirtualServer
 *
 * @mixin \Eloquent
 */
class UserTeamSpeakVirtualServer extends Model
{
    public function instance()
    {
        return $this->belongsTo('Api\TeamSpeakInstances', 'id', 'instance_id');
    }

    public function user()
    {
        return $this->belongsTo('Api\User', 'id', 'user_id');
    }
}
