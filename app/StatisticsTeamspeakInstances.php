<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Api\StatisticsTeamspeakInstances
 *
 * @property int $id
 * @property int $server_id
 * @property int $slot_usage
 * @property int $server_runing
 * @property int $user_online
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances dayAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances fiveMinutesAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances halfHourAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances hourAvage()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances serverID( $server_id )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances statDay( $InitialSearchDate = null )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances statMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances statRealtime( $InitialSearchDate = null )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances statWeek( $InitialSearchDate = null )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances statYear( $InitialSearchDate = null )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereServerId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereServerRuning( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereSlotUsage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereUserOnline( $value )
 * @mixin \Eloquent
 * @property int $instance_id
 * @property-read \Api\TeamspeakInstances $instance
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances instanceId( $instance_id )
 * @method static \Illuminate\Database\Eloquent\Builder|\Api\StatisticsTeamspeakInstances whereInstanceId( $value )
 */
class StatisticsTeamspeakInstances extends Model {
	protected $hidden = [ 'id', 'updated_at', 'instance_id' ];

	public function scopeInstanceId( $query, $instance_id ) {
		return $query->where( 'instance_id', $instance_id );
	}

	public function scopeStatYear( $query, $InitialSearchDate = null ) {
		if ( empty( $InitialSearchDate ) || strtotime( $InitialSearchDate ) < mktime( 0, 0, 0, date( "m" ), date( "d" ), date( "Y" ) - 1 ) ) {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", mktime( 0, 0, 0, date( "m" ), date( "d" ), date( "Y" ) - 1 ) ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		} else {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", strtotime( $InitialSearchDate ) ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		}
	}

	public function scopeStatMonth( $query, $InitialSearchDate = null ) {
		if ( empty( $InitialSearchDate ) || strtotime( $InitialSearchDate ) < mktime( 0, 0, 0, date( "m" ) - 1, date( "d" ), date( "Y" ) ) ) {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", mktime( 0, 0, 0, date( "m" ) - 1, date( "d" ), date( "Y" ) ) ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		} else {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", strtotime( $InitialSearchDate ) ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		}
	}

	function scopeStatWeek( $query, $InitialSearchDate = null ) {
		if ( empty( $InitialSearchDate ) || strtotime( $InitialSearchDate ) < time() - 7 * 24 * 60 * 60 ) {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", time() - 7 * 24 * 60 * 60 ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		} else {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", strtotime( $InitialSearchDate ) ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		}
	}

	function scopeStatDay( $query, $InitialSearchDate = null ) {
		if ( empty( $InitialSearchDate ) || strtotime( $InitialSearchDate ) < time() - 24 * 60 * 60 ) {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", time() - 24 * 60 * 60 ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		} else {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", strtotime( $InitialSearchDate ) ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		}
	}

	function scopeStatRealtime( $query, $InitialSearchDate = null ) {
		if ( empty( $InitialSearchDate ) || strtotime( $InitialSearchDate ) < time() - 60 * 60 ) {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", time() - 60 * 60 ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		} else {
			return $query->whereBetween( 'created_at', [
				date( "Y-m-d H:i:s", strtotime( $InitialSearchDate ) ),
				date( "Y-m-d H:i:s" )
			] )->orderBy( 'created_at' );
		}
	}

	function scopeFiveMinutesAvage( $query ) {
		return $query
			->select( DB::raw( 'avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at' ) )
			->groupBy( DB::raw( 'floor((unix_timestamp(created_at))/300 ),hour(created_at)' ) );
	}

	function scopeHalfHourAvage( $query ) {
		return $query
			->select( DB::raw( 'avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at' ) )
			->groupBy( DB::raw( 'FLOOR((UNIX_TIMESTAMP(created_at) - 1800) / 3600),hour(created_at)' ) );
	}

	public function scopeHourAvage( $query ) {
		return $query
			->select( DB::raw( 'avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at' ) )
			->groupBy( DB::raw( 'DAY(created_at),HOUR(created_at)' ) );
	}

	public function scopeDayAvage( $query ) {
		return $query
			->select( DB::raw( 'avg(slot_usage) as slot_usage ,avg(server_runing) as server_runing,avg(user_online) as user_online,created_at' ) )
			->groupBy( DB::raw( 'MONTH(created_at), DAYOFMONTH(created_at)' ) );
	}

	public function instance() {
		return $this->belongsTo( 'App\TeamspeakInstances', 'id', 'instance_id' );
	}

}
