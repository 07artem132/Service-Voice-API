<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Api\UserToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $scope
 * @property string $allow_ip
 * @property int $app_type
 * @property int $Blocked
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Api\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken firstCreated()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Api\UserToken onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken token($token)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken user($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereAllowIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereAppType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserToken whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Api\UserToken withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Api\UserToken withoutTrashed()
 * @mixin \Eloquent
 */
class UserToken extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = ['id', 'Blocked', 'user_id', 'deleted_at'];

    public function scopeUser($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);

    }

    public function scopeToken($query, $token)
    {
        return $query->where('token', '=', $token);

    }

    public function User()
    {
        return $this->hasOne('Api\User','id');
    }

    public function scopeFirstCreated($query)
    {
        return $query->orderBy('created_at','asc')->first();

    }

}
