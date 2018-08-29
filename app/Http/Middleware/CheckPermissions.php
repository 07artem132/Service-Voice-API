<?php

namespace Api\Http\Middleware;

use Api\Exceptions\AuthenticationException;
use Closure;
use Auth;
use Api\UserToken;

class CheckPermissions {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @param  string $permissions
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next, $permissions ) {
		$searchArrayKeys = array();
		$searchArrayVals = array();

		foreach ( $request->route()->parameters() as $key => $val ) {
			$searchArrayKeys[] = '{' . $key . '}';
			$searchArrayVals[] = $val;
		}

		$permissions = str_replace( $searchArrayKeys, $searchArrayVals, $permissions );

		$token           = $request->header( 'X-token' );
		$tokenDB         = UserToken::Token( $token )->firstOrFail();
		$TokenPrivileges = json_decode( $tokenDB->privileges->privilege );

		if ( ! array_key_exists( $permissions, $TokenPrivileges ) && ! array_key_exists( 'api.admin', $TokenPrivileges ) ) {
			return response()->json( [
				'status'  => 'error',
				'message' => 'Нет привилегии: ' . $permissions
			] );
		}

		return $next( $request );
	}

}
