<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\GroupServer
 *
 * @property int $server_id
 * @property int $group_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupServer server($server_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupServer whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupServer whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupServer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupServer extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeServer($query, $server_id)
    {
        $query->where('server_id', '=', $server_id);
    }
}
