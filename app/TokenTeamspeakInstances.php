<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TokenTeamspeakInstances extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['id', 'token_id', 'updated_at', 'deleted_at'];

    public function token()
    {
        return $this->belongsTo('Api\UserToken', 'id', 'token_id');
    }

    public function instance()
    {
        return $this->belongsTo('Api\TeamSpeakInstances', 'id', 'instance_id');
    }

}
