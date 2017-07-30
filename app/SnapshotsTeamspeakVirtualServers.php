<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\SnapshotsTeamspeakVirtualServers
 *
 * @property int $id
 * @property int $server_id
 * @property string $unique_id
 * @property string|null $port
 * @property string $snapshot
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers snapshot($snapshot_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers snapshotList($uid, $server_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers userSnapshot($server_id, $uid, $snapshot_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers whereSnapshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\SnapshotsTeamspeakVirtualServers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SnapshotsTeamspeakVirtualServers extends Model
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
    public function instance()
    {
        return $this->belongsTo('Api\TeamspeakInstances', 'id','instance_id');
    }

}
