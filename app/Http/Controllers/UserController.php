<?php

namespace Api\Http\Controllers;

use Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Api\Http\Controllers\TokenController;

class UserController extends Controller {
	public static function Exist( $email ): ?UserInterface {
		$user = Sentinel::findByCredentials( [ 'email' => $email ] );

		return $user;
	}

	public static function Create( $email, $password ) {
		$user = Sentinel::register( [ 'email' => $email, 'password' => $password ] );

		return $user;
	}

	public static function CreateToken( $user_id, $RequestedPrivileges ): string {
		$TokenController = new TokenController();
		$Token           = $TokenController->Generate();
		$TokenController->SaveToken( $user_id, $Token, '*', '1' );
		$Token = $TokenController->Search( $user_id, $Token );
		$TokenController->SaveAssociationTokenToPrivileges( $Token->id, $RequestedPrivileges );

		return $Token->token;
	}
}
