<?php

namespace Api\Http\Controllers;


use Sentinel;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Roles\RoleInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRoleController extends Controller {
	/**
	 * @param $slug
	 *
	 * @return RoleInterface|null
	 */
	public static function Exist( $slug ): ?RoleInterface {

		$Role = Sentinel::findRoleBySlug( $slug );

		return $Role;
	}

	/**
	 * @param string $slug
	 *
	 * @return RoleInterface
	 */
	public static function Get( string $slug ): RoleInterface {
		$Role = Sentinel::findRoleBySlug( $slug );

		return $Role;
	}

	/**
	 * @param string $name
	 * @param string $slug
	 *
	 * @return RoleInterface
	 */
	public static function Create( string $name, string $slug ): RoleInterface {
		$role = Sentinel::getRoleRepository()->createModel()->create( [
			'name' => $name,
			'slug' => $slug,
		] );

		return $role;
	}

	/**
	 * @param Collection $Roles
	 *
	 * @return array|null
	 */
	public static function GetPerm( Collection $Roles ): ?array {
		$PermList = $Roles[0]->toArray()['permissions'];
		$Roles    = array_except( $Roles, [ 0 ] );
		foreach ( $Roles as $Role ) {
			if ( empty( $PermList ) ) {
				$PermList = $Role->permissions;
				continue;
			}
			foreach ( $Role->permissions as $Perm => $value ) {
				if ( array_key_exists( $Perm, $PermList ) ) {
					$PermList[ $Perm ] = (bool) ( $PermList[ $Perm ] & $value );
				} else {
					$PermList[ $Perm ] = $value;
				}
			}
		}

		return $PermList;
	}
}
