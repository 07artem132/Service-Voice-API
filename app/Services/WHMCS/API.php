<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 26.06.2017
 * Time: 16:12
 */

namespace Api\Services\WHMCS;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as HTTPClient;
use Api\Exceptions\BillingIsNotAvailable;
use Api\Exceptions\BillingValidateLoginException;
use GuzzleHttp\Exception\RequestException;

class API {
	private $request;
	private $params;

	public function __construct() {
		$this->request = new HTTPClient();
	}

	private function GetIdentifier(): string {
		return env( 'BILLING_ID' );
	}

	private function GetUsername(): string {
		return env( 'BILLING_USERNAME' );
	}

	private function GetSecret(): string {
		return env( 'BILLING_SECRET' );
	}

	private function GetPassword(): string {
		return env( 'BILLING_PASSWORD' );
	}

	private function GetApiUrl(): string {
		return env( 'BILLING_API_URL' );
	}

	private function ParamsAdd( string $key, $value ): void {
		$this->params['form_params'][ $key ] = $value;
	}

	private function GetParams(): array {
		return $this->params;
	}

	private function SetAction( string $Action ): void {
		$this->ParamsAdd( 'action', $Action );
	}

	private function send(): Response {
		if ( env( 'BILLING_7_2_AND_ABOVE', false ) ) {
			$this->ParamsAdd( 'identifier', $this->GetIdentifier() );
			$this->ParamsAdd( 'secret', $this->GetSecret() );
		} else {
			$this->ParamsAdd( 'username', $this->GetUsername() );
			$this->ParamsAdd( 'password', $this->GetPassword() );
		}

		$this->ParamsAdd( 'responsetype', 'json' );

		try {
			$response = $this->request->post( $this->GetApiUrl(), $this->GetParams() );
		} catch ( RequestException $e ) {
			$data = json_decode( $e->getResponse()->getBody()->getContents() );
			throw  new BillingIsNotAvailable( $data->message );
			//TODO Не показывать пользователю ошибку, а создать событие и залогировать
		}

		return $response;
	}

	function ValidateCredentials( string $email, string $password ): \stdClass {
		$this->SetAction( 'ValidateLogin' );
		$this->ParamsAdd( 'email', $email );
		$this->ParamsAdd( 'password2', $password );

		$response = $this->send();
		$response = json_decode( $response->getBody() );

		if ( $response->result != 'success' ) {
			throw new  BillingValidateLoginException( $response->message );
		}

		return $response;
	}

	function GetClientsDetails( int $clientid, bool $stats ): \stdClass {
		$this->SetAction( 'GetClientsDetails' );
		$this->ParamsAdd( 'clientid', $clientid );
		$this->ParamsAdd( 'stats', $stats );

		$response = $this->send();
		$response = json_decode( $response->getBody() );

		return $response;
	}

	function GetClientGroups(): \stdClass {
		$this->SetAction( 'GetClientGroups' );

		$response = $this->send();
		$response = json_decode( $response->getBody() );

		return $response;
	}
}