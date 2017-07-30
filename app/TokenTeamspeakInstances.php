<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Api\TokenTeamspeakInstances
 *
 * @property int $id
 * @property int $token_id
 * @property int $instance_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Api\TeamspeakInstances $instance
 * @property-read \Api\UserToken $token
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenTeamspeakInstances onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakInstances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakInstances whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakInstances whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakInstances whereInstanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakInstances whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenTeamspeakInstances whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenTeamspeakInstances withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenTeamspeakInstances withoutTrashed()
 * @mixin \Eloquent
 */
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
        return $this->belongsTo('Api\TeamspeakInstances', 'id', 'instance_id');
    }

}
