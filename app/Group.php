<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $hidden = ['created_at', 'id', 'updated_at'];

    public function Servers()
    {
        return $this->hasMany('Api\GroupServer', 'group_id');
    }

    public function scopeGroup($query, $group)
    {
        $query->where('slug', '=', $group);
    }
}
