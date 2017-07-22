<?php

namespace Api;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Api\User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $permissions
 * @property string|null $last_login
 * @property string|null $first_name
 * @property string|null $last_name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\UserToken[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User firstCreatedToken()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user can have many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany('Api\UserToken', 'user_id');
    }

    public function scopeFirstCreatedToken()
    {
        return $this->hasMany('Api\UserToken', 'user_id')->FirstCreated();
    }

}
