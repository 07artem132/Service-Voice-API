<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Api\TokenPrivileges
 *
 * @property int $id
 * @property int $token_id
 * @property string $privilege
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Api\UserToken $token
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenPrivileges onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenPrivileges whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenPrivileges whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenPrivileges whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenPrivileges wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenPrivileges whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\TokenPrivileges whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenPrivileges withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Api\TokenPrivileges withoutTrashed()
 * @mixin \Eloquent
 */
class TokenPrivileges extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['id', 'token_id','created_at','deleted_at'];

    public function token()
    {
        return $this->belongsTo('Api\UserToken', 'id', 'token_id');
    }

}
