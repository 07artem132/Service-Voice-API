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

}
