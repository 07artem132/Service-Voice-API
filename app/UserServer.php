<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\UserServer
 *
 * @property int $id
 * @property string $user_id
 * @property string $server_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserServer whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserServer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\UserServer whereUserId($value)
 * @mixin \Eloquent
 */
class UserServer extends Model
{
    //
}
