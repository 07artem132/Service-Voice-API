<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 04.07.2017
 * Time: 22:27
 */

namespace Api\Http\Controllers;

use Api\Http\Requests\TokenControllerCreateRequest;
use Auth;
use Api\UserToken;
use Api\TokenTeamspeakInstances;
use Api\TokenPrivileges;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Api\Exceptions\RequestIsNotJson;
use Api\Exceptions\RequestPrivilegesIsNotAllow;
use Api\Exceptions\RequestTeamspeakVirtualServersIsNotAllow;
use Api\Exceptions\RequestTeamSpeakInstanseIsNotAllow;
use Api\TokenTeamspeakVirtualServers;
use Api\Traits\RestSuccessResponseTrait;
use Illuminate\Database\Eloquent\Collection;
use Api\Exceptions\TokenNotAllowedDeleteException;

class TokenController extends Controller {
	use RestSuccessResponseTrait;

	/**
	 * @api {delete} /v1//token/:token Удалить
	 * @apiName Token delete
	 * @apiGroup Token
	 * @apiVersion 1.0.0
	 * @apiDescription Удаляет переданный токен (пользователь должен быть владельцем токена) <br/><br/>
	 * <b>Внимание! Удалить основной токен нельзя.</b><br/>
	 * Под основным подразумевается первый созданный (выданный в месте с аккаунтом)
	 * @apiSampleRequest /v1//token/:token
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.token.delete
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 * }
	 */
	/**
	 * @param string $token
	 *
	 * @return JsonResponse
	 */
	function Delete( string $token ): JsonResponse {
		$FirstToken = UserToken::UserWhere( Auth::id() )->FirstCreated()->first();

		if ( $FirstToken->token == $token ) {
			throw new TokenNotAllowedDeleteException();
		}

		$token = UserToken::UserWhere( Auth::id() )->Token( $token )->firstOrFail();

		TokenTeamspeakInstances::where( 'token_id', '=', $token->id )->delete();
		TokenTeamspeakVirtualServers::where( 'token_id', '=', $token->id )->delete();
		TokenPrivileges::where( 'token_id', '=', $token->id )->delete();
		UserToken::Token( $token->token )->delete();

		return $this->jsonResponse();
	}

	/**
	 * @api {get} /v1/token/ Список
	 * @apiName Token list
	 * @apiGroup Token
	 * @apiVersion 1.0.0
	 * @apiDescription Возврашает список токенов <br/><br/>
	 * @apiSampleRequest /v1/token/
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.token.delete
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":[
	 *    {
	 *      "token":"dJ2sweBQoQUAiMqYApg3oOiZeJ2TDiCuwbfaz15TlLLoeQsgquBPAQIrFRizLXhLkpBARyOzhA4afdeoajjWkMTQZhaS8YuXAaRp",
	 *      "allow_ip":"*",
	 *      "app_type":1,
	 *      "created_at":"2017-07-29 17:37:52",
	 *      "updated_at":"2017-07-29 17:37:52",
	 *      "servers":[
	 *        {
	 *          "server_id":1,
	 *          "created_at":"2017-07-29 17:37:52"
	 *        },
	 *        {
	 *          "server_id":2,
	 *          "created_at":"2017-07-29 17:37:52"
	 *        }
	 *      ],
	 *      "privileges":{
	 *        "privilege":"[\"api.usage\"]",
	 *        "updated_at":"2017-07-29 17:37:52"
	 *      },
	 *      "teamspeak_virtual_servers":[
	 *        {
	 *          "server_id":1,
	 *          "unique_id":"32",
	 *          "created_at":"2017-07-29 17:37:52"
	 *        }
	 *      ]
	 *    },
	 *    {
	 *      "token":"dJ2sweBQoQUAiMqYApg3oOiZeJ2TDiCuwbfaz15TlLLoeQsgquBPAQIrFRizLXhLkpBARyOzhA4afdeoajjWkMTQZhaS8asdfAaRp",
	 *      "allow_ip":"*",
	 *      "app_type":1,
	 *      "created_at":"2017-07-29 17:37:52",
	 *      "updated_at":"2017-07-29 17:37:52",
	 *      "servers":[
	 *        {
	 *          "server_id":3,
	 *          "created_at":"2017-07-29 17:37:52"
	 *        },
	 *        {
	 *          "server_id":4,
	 *          "created_at":"2017-07-29 17:37:52"
	 *        }
	 *      ],
	 *      "privileges":{
	 *        "privilege":"[\"api.usage\"]",
	 *        "updated_at":"2017-07-29 17:37:52"
	 *      },
	 *      "teamspeak_virtual_servers":[
	 *        {
	 *          "server_id":1,
	 *          "unique_id":"32",
	 *          "created_at":"2017-07-29 17:37:52"
	 *        }
	 *      ]
	 *    }
	 *  ]
	 *}
	 */
	/**
	 * @return JsonResponse
	 */
	function List(): JsonResponse {
		$Tokens = UserToken::with( 'servers', 'privileges', 'TeamspeakVirtualServers' )->UserWhere( Auth::id() )->get();

		return $this->jsonResponse( $Tokens );
	}

	/**
	 * @api {post} /v1/token/ Создать
	 * @apiName Token create
	 * @apiGroup Token
	 * @apiVersion 1.0.0
	 * @apiDescription Создает токен <br/><br/>
	 * <b>При создании вам необходимо передать параметры</b><br/>
	 *{<br/>
	 * &nbsp;"privilege":{<br/>
	 * &nbsp;&nbsp;&nbsp;"api.usage":true,<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"api.token.list":true<br/>
	 * &nbsp;},<br/>
	 * &nbsp;"allow_ip":"*",<br/>
	 * &nbsp;"app_type":"1",<br/>
	 * &nbsp;"server_allow":[<br/>
	 * &nbsp;&nbsp;&nbsp;1,<br/>
	 * &nbsp;&nbsp;&nbsp;2<br/>
	 * &nbsp;],<br/>
	 * &nbsp;"teamspeak_virtual_server_allow":[<br/>
	 * &nbsp;&nbsp;&nbsp;{<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"server_id":"1",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"unique_id":"vzdstqwhweas"<br/>
	 * &nbsp;&nbsp;&nbsp;},<br/>
	 * &nbsp;&nbsp;&nbsp;{<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"server_id":"1",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"unique_id":"vasqwerwqfgasdg"<br/>
	 * &nbsp;&nbsp;&nbsp;}<br/>
	 * &nbsp;]<br/>
	 *}<br/>
	 * <br/><br/><b>Внимание! Особенности работы!</b><br/>
	 * Вы можете создать токен с меньшими или такими же правами как у переданного токена в заголовке X-token (если у токена есть привелегия api.token.create)
	 * @apiSampleRequest off
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.token.create
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":{
	 *    "token":"dJ2sweBQoQUAiMqYApg3oOiZeJ2TDiCuwbfaz15TlLLoeQsgquBPAQIrFRizLXhLkpBARyOzhA4afdeoajjWkMTQZhaS8YuXAaRp",
	 *    "allow_ip":"*",
	 *    "app_type":1,
	 *    "created_at":"2017-07-29 17:37:52",
	 *    "updated_at":"2017-07-29 17:37:52",
	 *    "servers":[
	 *      {
	 *        "server_id":1,
	 *        "created_at":"2017-07-29 17:37:52"
	 *      },
	 *      {
	 *        "server_id":2,
	 *        "created_at":"2017-07-29 17:37:52"
	 *      }
	 *    ],
	 *    "privileges":{
	 *      "privilege":"[\"api.usage\"]",
	 *      "updated_at":"2017-07-29 17:37:52"
	 *    },
	 *    "teamspeak_virtual_servers":[
	 *      {
	 *        "server_id":1,
	 *        "unique_id":"32",
	 *        "created_at":"2017-07-29 17:37:52"
	 *      }
	 *    ]
	 *  }
	 *}
	 */
	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 * @throws RequestIsNotJson
	 */
	function Create( TokenControllerCreateRequest $request ): JsonResponse {

		$TransmittedToken = $this->Search( Auth::id(), $request->header( 'X-token' ) );

		$AllowPrivList                = json_decode( $TransmittedToken->privileges->privilege );
		$AllowServers                 = $TransmittedToken->servers;
		$AllowTeamspeakVirtualServers = $TransmittedToken->TeamspeakVirtualServers;

		$RequestedTeamSpeakVirtualServer = $request->input( 'teamspeak_virtual_server_allow' );
		$RequestedServer                 = $request->input( 'server_allow' );
		$RequestedPrivileges             = $request->input( 'privilege' );
		$Allow_ip                        = $request->input( 'allow_ip' );
		$app_type                        = $request->input( 'app_type' );
		$user_id                         = Auth::id();
		$token                           = $this->GenerateToken();

		$this->VerifiAllowPriv( $AllowPrivList, $RequestedPrivileges );
		$this->VerifiAllowServers( $AllowServers, $RequestedServer );
		$this->VerifiAllowTeamspeakVirtualServers( $AllowTeamspeakVirtualServers, $RequestedTeamSpeakVirtualServer );

		$this->SaveToken( $user_id, $token, $Allow_ip, $app_type );
		$token = $this->Search( Auth::id(), $token );

		$this->SaveAssociationTokenToTeamspeakVirtualServers( $token->id, $RequestedTeamSpeakVirtualServer );
		$this->SaveAssociationTokenToServers( $token->id, $RequestedServer );
		$this->SaveAssociationTokenToPrivileges( $token->id, $RequestedPrivileges );

		$token = UserToken::with( 'servers', 'privileges', 'TeamspeakVirtualServers' )->UserWhere( Auth::id() )->Token( $token->token )->first();

		return $this->jsonResponse( $token );
	}

	function Search( $user_id, $Token ): UserToken {
		return UserToken::UserWhere( $user_id )->Token( $Token )->firstOrFail();
	}

	function Generate(): string {
		return str_random( 100 );
	}

	/**
	 * @param int $token_id
	 * @param array $Privilege
	 */
	function SaveAssociationTokenToPrivileges( int $token_id, array $Privilege ): void {
		$TokenServersDbSave            = new TokenPrivileges;
		$TokenServersDbSave->token_id  = $token_id;
		$TokenServersDbSave->privilege = json_encode( $Privilege );
		$TokenServersDbSave->saveOrFail();

		return;
	}

	/**
	 * @param int $token_id
	 * @param array $servers_id
	 */
	function SaveAssociationTokenToServers( int $token_id, array $servers_id ): void {
		for ( $i = 0; $i < count( $servers_id ); $i ++ ) {
			$TokenServersDbSave            = new TokenTeamspeakInstances;
			$TokenServersDbSave->token_id  = $token_id;
			$TokenServersDbSave->server_id = $servers_id[ $i ];
			$TokenServersDbSave->saveOrFail();
		}

		return;
	}

	/**
	 * @param int $token_id
	 * @param array $TeamSpeakVirtualServer
	 */
	function SaveAssociationTokenToTeamspeakVirtualServers( int $token_id, array $TeamSpeakVirtualServer ) {
		for ( $i = 0; $i < count( $TeamSpeakVirtualServer ); $i ++ ) {
			$TokenTeamspeakVirtualServersDbSave            = new TokenTeamspeakVirtualServers;
			$TokenTeamspeakVirtualServersDbSave->token_id  = $token_id;
			$TokenTeamspeakVirtualServersDbSave->server_id = $TeamSpeakVirtualServer[ $i ]['server_id'];
			$TokenTeamspeakVirtualServersDbSave->unique_id = $TeamSpeakVirtualServer[ $i ]['unique_id'];
			$TokenTeamspeakVirtualServersDbSave->saveOrFail();
		}

		return;
	}

	/**
	 * @param int $user_id
	 * @param string $token
	 * @param string $allow_ip
	 * @param string $app_type
	 */
	function SaveToken( int $user_id, string $token, string $allow_ip, string $app_type ): void {
		$TokenDbSave           = new UserToken;
		$TokenDbSave->user_id  = $user_id; //Auth::id();
		$TokenDbSave->token    = $token;
		$TokenDbSave->allow_ip = $allow_ip;
		$TokenDbSave->app_type = $app_type;
		$TokenDbSave->Blocked  = 0;
		$TokenDbSave->saveOrFail();

		return;
	}

	/**
	 * @param \stdClass $AllowPrivList
	 * @param array $RequestedPrivileges
	 */
	function VerifiAllowPriv( \stdClass $AllowPrivList, array $RequestedPrivileges ): void {
		foreach ( $RequestedPrivileges as $key => $value ) {
			if ( ! key_exists( $key, $AllowPrivList ) ) {
				throw new RequestPrivilegesIsNotAllow();
			}
		}

		return;
	}

	/**
	 * @param Collection $AllowServers
	 * @param array $RequestedServer
	 */
	function VerifiAllowServers( Collection $AllowServers, array $RequestedServer ): void {
		foreach ( $RequestedServer as $key ) {
			for ( $i = 0, $Found = false; $i < $AllowServers->count(); $i ++ ) {
				if ( $key == $AllowServers[ $i ]['server_id'] ) {
					$Found = true;
				}
			}

			if ( $Found != true ) {
				throw new RequestTeamSpeakInstanseIsNotAllow();
			}
		}

		return;
	}

	/**
	 * @param Collection $AllowTeamspeakVirtualServers
	 * @param array $RequestedTeamSpeakVirtualServer
	 */
	function VerifiAllowTeamspeakVirtualServers( Collection $AllowTeamspeakVirtualServers, array $RequestedTeamSpeakVirtualServer ): void {
		foreach ( $RequestedTeamSpeakVirtualServer as $key ) {
			for ( $i = 0, $Found = false; $i < count( $AllowTeamspeakVirtualServers ); $i ++ ) {
				if ( $key['server_id'] === $AllowTeamspeakVirtualServers[ $i ]['server_id'] &&
				     $key['unique_id'] === $AllowTeamspeakVirtualServers[ $i ]['unique_id'] ) {
					$Found = true;
				}
			}
			if ( $Found != true ) {
				throw new RequestTeamspeakVirtualServersIsNotAllow();
			}
		}

		return;
	}
}