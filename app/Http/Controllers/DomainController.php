<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 11.07.2017
 * Time: 22:47
 */

namespace Api\Http\Controllers;

use Api\Http\Requests\DomainRecordDeleteRequest;
use Api\Traits\RestHelperTrait;
use Illuminate\Http\JsonResponse;
use Api\Services\Domain\PowerDNS;
use Api\Http\Requests\DomainAddRequest;
use Api\Traits\RestSuccessResponseTrait;
use Api\Http\Requests\DomainRecordAddRequest;
use Api\UserToken;

/**
 * Class DomainController
 * @package Api\Http\Controllers
 */
class DomainController extends Controller {
	use RestSuccessResponseTrait;
	use RestHelperTrait;
	private $PowerDNS;

	/**
	 * @api {get} /v1/domain Список доменов
	 * @apiName Domain list
	 * @apiGroup Domain PowerDNS
	 * @apiVersion 1.0.0
	 * @apiDescription Возвращает список доменов с которыми можно взаимодействовать.
	 * @apiSampleRequest /domain
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.domain.list
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *    "data": [
	 *   {
	 *       "dnssec": false,
	 *       "id": "example2.com.",
	 *       "kind": "Master",
	 *       "last_check": 0,
	 *       "masters": [],
	 *       "name": "example2.com.",
	 *       "notified_serial": 2017071602,
	 *       "serial": 2017071602
	 *   },
	 *   {
	 *       "dnssec": false,
	 *       "id": "example.com.",
	 *       "kind": "Master",
	 *       "last_check": 0,
	 *       "masters": [],
	 *       "name": "example.com.",
	 *       "notified_serial": 2017071602,
	 *       "serial": 2017071602
	 *   }
	 *  ]
	 *}
	 */
	/**
	 * Возврашает список доменов
	 * @return \Illuminate\Http\JsonResponse
	 */
	function List(): JsonResponse {
		$this->PowerDNS = new PowerDNS();
		$DomainList     = (array) $this->PowerDNS->DomainList();

		$token      = request()->header( 'X-token' );
		$DomainList = $this->FilteredDomain( $DomainList, $token );

		return $this->jsonResponse( $DomainList );
	}

	function FilteredDomain( array $DomainList, string $token ): array {
		$tokenDB         = UserToken::Token( $token )->firstOrFail();
		$TokenPrivileges = json_decode( $tokenDB->privileges->privilege );

		if ( array_key_exists( 'api.admin', $TokenPrivileges ) ) {
			return $DomainList;
		}

		$filtered = array_where( $DomainList, function ( $value, $key ) use ( $TokenPrivileges ) {
			return array_key_exists( 'api.' . $value->name . 'record.list', $TokenPrivileges ) ? true : false;
		} );

		return $filtered;
	}

	/**
	 * @api {get} /v1/domain/{domain}/record/formated Отформатированный список записей домена
	 * @apiName Domain record formated list
	 * @apiGroup Domain PowerDNS
	 * @apiVersion 1.0.0
	 * @apiDescription Возвращает отформатированный список DNS записей домена
	 * @apiSampleRequest /domain/{domain}/record/formated
	 * @apiParam {String} domain Доменное имя.
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.{domain}.record.formated.list
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *    "data": {
	 *        "MX": [
	 *            {
	 *                "name": "mx.example.com.",
	 *                "records": [
	 *                    {
	 *                        "Priority": "10",
	 *                        "MailRelay": "mail.example.com.",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "TXT": [
	 *            {
	 *                "name": "text.example.com.",
	 *                "records": [
	 *                    {
	 *                        "Text": "\"text\"",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "CNAME": [
	 *            {
	 *                "name": "cname.example.com.",
	 *                "records": [
	 *                    {
	 *                        "CanonicalName": "v4.example.com.",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "AAAA": [
	 *            {
	 *                "name": "v6.example.com.",
	 *                "records": [
	 *                    {
	 *                        "ipv6": "fd32:4810:8cae:71d9:71d9:71d9:71d9:71d9",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "PTR": [
	 *            {
	 *                "name": "103.0.3.26.example.com.",
	 *                "records": [
	 *                    {
	 *                        "HostName": "mail.example.com.",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "SRV": [
	 *            {
	 *                "name": "_ts3._udp.v4.example.com.",
	 *                "records": [
	 *                    {
	 *                        "Priority": "0",
	 *                        "Weight": "0",
	 *                        "Port": "9987",
	 *                        "Target": "v4.example.com.",
	 *                        "disabled": false
	 *                    },
	 *                    {
	 *                        "Priority": "0",
	 *                        "Weight": "0",
	 *                        "Port": "9987",
	 *                        "Target": "v4.example.com.",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 300,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "A": [
	 *            {
	 *                "name": "v4.example.com.",
	 *                "records": [
	 *                    {
	 *                       "ipv4": "127.0.0.1",
	 *                        "disabled": false
	 *                    },
	 *                    {
	 *                        "ipv4": "127.0.0.1",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "SOA": [
	 *            {
	 *                "name": "example.com.",
	 *                "records": [
	 *                    {
	 *                        "content": "ns01.service-voice.com. info.service-voice.com. 2017071382 10800 3600 604800 3600",
	 *                       "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ],
	 *        "NS": [
	 *            {
	 *                "name": "example.com.",
	 *                "records": [
	 *                    {
	 *                        "NameServer": "ns01.example.com.",
	 *                        "disabled": false
	 *                    }
	 *                ],
	 *                "ttl": 60,
	 *                "comments": []
	 *            }
	 *        ]
	 *    }
	 *}
	 */
	/**
	 * Возврашает отформатированный список записей домена
	 *
	 * @param string $domain домен
	 *
	 * @return JsonResponse Обьект с данными для ответа
	 */
	function RecordFormatedList( string $domain ): JsonResponse {
		$this->PowerDNS   = new PowerDNS();
		$DomainRecordList = $this->PowerDNS->DomainRecordFormatedList( $domain );

		return $this->jsonResponse( $DomainRecordList );
	}

	/**
	 * @api {get} /v1/domain/:domain/record Cписок записей домена
	 * @apiName Domain record list
	 * @apiGroup Domain PowerDNS
	 * @apiVersion 1.0.0
	 * @apiDescription Возвращает список DNS записей домена
	 * @apiSampleRequest /domain/:domain/record
	 * @apiParam {String} domain Доменное имя.
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.{domain}.record.list
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
	 *      "type":"MX",
	 *      "name":"mx.example.com.",
	 *      "records":[
	 *        {
	 *          "content":"10 mail.example.com.",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"TXT",
	 *      "name":"text.example.com.",
	 *      "records":[
	 *        {
	 *          "content":"\"text\"",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"CNAME",
	 *      "name":"cname.example.com.",
	 *      "records":[
	 *        {
	 *          "content":"v4.example.com.",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"AAAA",
	 *      "name":"v6.example.com.",
	 *      "records":[
	 *        {
	 *          "content":"fd32:4810:8cae:71d9:71d9:71d9:71d9:71d9",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"PTR",
	 *      "name":"103.0.3.26.example.com.",
	 *      "records":[
	 *        {
	 *          "content":"mail.example.com.",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"SRV",
	 *      "name":"_ts3._udp.v4.example.com.",
	 *      "records":[
	 *        {
	 *          "content":"0 0 9987 v4.example.com.",
	 *          "disabled":false
	 *        },
	 *        {
	 *          "content":"0 0 9987 v4.example.com.",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":300,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"A",
	 *      "name":"v4.example.com.",
	 *      "records":[
	 *        {
	 *          "content":"127.0.0.1",
	 *          "disabled":false
	 *        },
	 *        {
	 *          "content":"127.0.0.1",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"SOA",
	 *      "name":"example.com.",
	 *      "records":[
	 *        {
	 *          "content":"ns01.service-voice.com. info.service-voice.com. 2017071382 10800 3600 604800 3600",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    },
	 *    {
	 *      "type":"NS",
	 *      "name":"example.com.",
	 *      "records":[
	 *        {
	 *          "content":"ns01.example.com.",
	 *          "disabled":false
	 *        }
	 *      ],
	 *      "ttl":60,
	 *      "comments":[
	 *
	 *      ]
	 *    }
	 *  ]
	 *}
	 */
	/**
	 * Возврашает список записей домена
	 *
	 * @param string $domain домен
	 *
	 * @return JsonResponse Обьект с данными для ответа
	 */
	function RecordList( string $domain ): JsonResponse {
		$this->PowerDNS   = new PowerDNS();
		$DomainRecordList = $this->PowerDNS->DomainRecordList( $domain );

		return $this->jsonResponse( $DomainRecordList );

	}

	/**
	 * @api {post} /v1/domain Создать домен
	 * @apiName Domain Add
	 * @apiGroup Domain PowerDNS
	 * @apiVersion 1.0.0
	 * @apiDescription Создает домен. <br/><br/>
	 * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
	 * {<br/>
	 * &nbsp; "name":"example04.org.",<br/>
	 * &nbsp; "kind":"master",<br/>
	 * &nbsp; "nameservers":[<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp; "ns01.example04.org.",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp; "ns03.example04.org."<br/>
	 * &nbsp;&nbsp;]<br/>
	 *}
	 * @apiSampleRequest /domain
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.domain.add
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":{
	 *    "dnssec":false,
	 *    "id":"example101111101.com.",
	 *    "kind":"Master",
	 *    "last_check":0,
	 *    "masters":[
	 *
	 *    ],
	 *    "name":"example101111101.com.",
	 *    "notified_serial":0,
	 *    "rrsets":[
	 *      {
	 *        "comments":[
	 *
	 *        ],
	 *        "name":"example101111101.com.",
	 *        "records":[
	 *          {
	 *            "content":"ns01.service-voice.com. info.service-voice.com. 2017072201 10800 3600 604800 3600",
	 *            "disabled":false
	 *          }
	 *        ],
	 *        "ttl":60,
	 *        "type":"SOA"
	 *      },
	 *      {
	 *        "comments":[
	 *
	 *        ],
	 *        "name":"example101111101.com.",
	 *        "records":[
	 *          {
	 *            "content":"ns01.example10.com.",
	 *            "disabled":false
	 *          },
	 *          {
	 *            "content":"ns2.example10.com.",
	 *            "disabled":false
	 *          }
	 *        ],
	 *        "ttl":60,
	 *        "type":"NS"
	 *      }
	 *    ],
	 *    "serial":2017072201,
	 *    "soa_edit":"",
	 *    "soa_edit_api":"DEFAULT"
	 *  }
	 *}
	 */
	/**
	 * Добавление домена
	 *
	 * @param DomainAddRequest $request обьект который содержит все данные запроса
	 *
	 * @return JsonResponse Обьект с данными для ответа
	 */
	function Add( DomainAddRequest $request ): JsonResponse {
		$this->PowerDNS = new PowerDNS();
		$Response       = $this->PowerDNS->DomainCreate(
			$request->input( 'name' ),
			$request->input( 'kind' ),
			$request->input( 'nameservers' )
		);

		return $this->jsonResponse( $Response );
	}

	/**
	 * @api {post} /v1/domain Удалить домен
	 * @apiName Domain delete
	 * @apiGroup Domain PowerDNS
	 * @apiVersion 1.0.0
	 * @apiDescription Удаляет домен
	 * @apiSampleRequest /domain
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.{domain}.delete
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *}
	 */
	/**
	 * @param string $domain домен из URL
	 *
	 * @return JsonResponse
	 */
	function Delete( string $domain ): JsonResponse {
		$this->PowerDNS = new PowerDNS();

		$this->PowerDNS->DomainDelete( $domain );

		return $this->jsonResponse( null );
	}

	/**
	 * @api {post} /v1/domain/{domain}/record Создать запись
	 * @apiName Domain Record Add
	 * @apiGroup Domain PowerDNS
	 * @apiVersion 1.0.0
	 * @apiDescription Создает запись для домена. <br/><br/>
	 * Возможно создание нескольких записей за 1 запрос <br/><br/>
	 * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
	 *{<br/>
	 * &nbsp;&nbsp;{ <br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"name":"ts1.service-voice.com.",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"type":"A",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"ttl":"60",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"records":[<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.1",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.2",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;]<br/>
	 * &nbsp;&nbsp;}<br/>
	 *}<br/>
	 * @apiSampleRequest off
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.{domain}.record.add
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiUse DOMAIN_EDIT_NOT_MATCH_DOMAIN_FROM_URL
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *}
	 */
	/**
	 * Добавление записи для домена
	 *
	 * @param DomainRecordAddRequest $request обьект который содержит все данные запроса
	 * @param string $domain домен
	 *
	 * @return JsonResponse Обьект с данными для ответа
	 */
	function RecordAdd( DomainRecordAddRequest $request, string $domain ): JsonResponse {
		$this->PowerDNS = new PowerDNS();
		$this->PowerDNS->DomainRecordCreate(
			$domain,
			$request->input( 'name' ),
			$request->input( 'type' ),
			$request->input( 'ttl' ),
			$request->input( 'records' )
		);

		return $this->jsonResponse( null );
	}

	/**
	 * @api {DELETE} /v1/domain/{domain}/record Удалить запись
	 * @apiName Domain Record Delete
	 * @apiGroup Domain PowerDNS
	 * @apiVersion 1.0.0
	 * @apiDescription Удаляет запись домена. <br/><br/>
	 * Возможно создание нескольких записей за 1 запрос <br/><br/>
	 * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
	 *{<br/>
	 * &nbsp;&nbsp;{ <br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"name":"ts1.service-voice.com.",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"type":"A",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"ttl":"60",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;"records":[<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.1",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.2",<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
	 * &nbsp;&nbsp;&nbsp;&nbsp;]<br/>
	 * &nbsp;&nbsp;}<br/>
	 *}<br/>
	 * @apiSampleRequest off
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.{domain}.record.delete
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiUse DOMAIN_EDIT_NOT_MATCH_DOMAIN_FROM_URL
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *}
	 */
	/**
	 * @param DomainRecordDeleteRequest $request обьект который содержит все данные запроса
	 * @param string $domain домен
	 *
	 * @return JsonResponse Обьект с данными для ответа
	 */
	function RecordDelete( DomainRecordDeleteRequest $request, string $domain ): JsonResponse {
		$this->PowerDNS = new PowerDNS();
		$this->PowerDNS->DomainRecordDelete(
			$domain,
			$request->input( 'name' ),
			$request->input( 'type' ),
			$request->input( 'ttl' ),
			$request->input( 'records' )
		);

		return $this->jsonResponse( null );
	}
}
