<?php

namespace Api\Http\Controllers;

use Api\Http\Controllers\UserController;
use Api\Services\WHMCS\API as WHMCS_API;
use Api\Traits\RestSuccessResponseTrait;
use Api\Http\Controllers\UserRoleController;
use Api\Http\Requests\UserRegistrationRequest;
use Api\Exceptions\UserAlreadyRegistered;

class UserRegistrationController extends Controller {
	use RestSuccessResponseTrait;

	function Form() {
		return view( 'RegistrationForm' );
	}

	function Registration( UserRegistrationRequest $request ) {
		$email    = $request->input( 'email' );
		$password = $request->input( 'password' );

		$WHMCSUserid = $this->VerifiAccountWHMCS( $email, $password )->userid;

		if ( empty( $user = UserController::Exist( $request->input( 'email' ) ) ) ) {
			$user = UserController::Create( $email, $password );

			$WHMCS_API      = new WHMCS_API();
			$ClientsDetails = $WHMCS_API->GetClientsDetails( $WHMCSUserid, false );

			$role = UserRoleController::Get( config( 'Billing.Client.Role.Default' ) );
			$role->users()->attach( $user );

			if ( $ClientsDetails->groupid != 0 ) {
				$slug = config( 'Billing.Client.Role.SuffixAutoCreateRole' ) . $ClientsDetails->groupid;
				$role = UserRoleController::Exist( $slug );

				if ( empty( $role ) ) {
					$Groups = $WHMCS_API->GetClientGroups();
					$name   = $Groups->groups->group[ $ClientsDetails->groupid ]->groupname;
					$role   = UserRoleController::Create( $name, $slug );
				}

				$role->users()->attach( $user );
			}

			$PermList = UserRoleController::GetPerm( $user->getRoles() );
			$token    = UserController::CreateToken( $user->getUserId(), $PermList );
		} else {
			throw  new UserAlreadyRegistered();
		}

		return $this->jsonResponse( $token );
	}

	function VerifiAccountWHMCS( string $email, string $password ): \stdClass {
		$WHMCS_API = new WHMCS_API();
		$result    = $WHMCS_API->ValidateCredentials( $email, $password );

		return $result;
	}

}
