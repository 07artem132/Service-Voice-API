<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

class SnapshotsVirtualServers extends Model
{
    protected $hidden = ['unique_id', 'server_id', 'id', 'updated_at'];

    public function scopeSnapshot($query, int $snapshot_id)
    {
        return $query->where('id', '=', $snapshot_id);
    }

    public function scopeUserSnapshot($query, int $server_id, string $uid, int $snapshot_id)
    {
        return $query->where(
            [
                ['server_id', '=', $server_id],
                ['unique_id', '=', $uid],
                ['id', '=', $snapshot_id]
            ]

        );
    }

    public function scopeSnapshotList($query, string $uid, int $server_id)
    {
        return $query->select('id', 'created_at')->where(
            [
                ['server_id', '=', $server_id],
                ['unique_id', '=', $uid],
            ]
        );

    }

}
