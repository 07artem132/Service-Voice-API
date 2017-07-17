<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

class SnapshotsVirtualServers extends Model
{
    protected $hidden = ['unique_id', 'server_id', 'id', 'updated_at'];

    public function scopeSnapshot($query, $snapshot_id)
    {
        return $query->where('id', '=', $snapshot_id);
    }

    public function scopeSnapshotList($query, $uid, $server_id)
    {
        return $query->select('id','created_at')->where(
            [
                ['server_id', '=', $server_id],
                ['unique_id', '=', $uid],
            ]
        );

    }

}
