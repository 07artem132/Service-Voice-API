<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

class GroupServer extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeServer($query, $server_id)
    {
        $query->where('server_id', '=', $server_id);
    }
}
