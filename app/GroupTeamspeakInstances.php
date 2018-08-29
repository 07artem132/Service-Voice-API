<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;

/**
 * Api\GroupTeamspeakInstances
 *
 * @property int $server_id
 * @property int $group_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances server( $server_id )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereGroupId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereServerId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property int $instance_id
 * @property-read \Api\Group $group
 * @property-read \Api\TeamspeakInstances $instance
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances whereInstanceId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances getInstance($instance_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\GroupTeamspeakInstances groupID($group_id)
 */
class GroupTeamspeakInstances extends Model {
	protected $hidden = [ 'created_at', 'updated_at','group_id' ];

	public function scopeGetInstance( $query, $instance_id ) {
		$query->where( 'instance_id', '=', $instance_id );
	}

	public function group() {
		return $this->belongsTo( 'Api\Group', 'id', 'group_id' );
	}

	public function scopeGroupID($query, $group_id) {
		$query->where('group_id', '=', $group_id);
	}

	public function instance() {
		return $this->hasOne( 'Api\TeamspeakInstances', 'id', 'instance_id' );
	}


}
