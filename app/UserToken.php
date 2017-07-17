<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
