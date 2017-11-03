<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 12:34
 */

namespace Api\Http\Controllers;

use Api\Group;
use Api\Http\Requests\TeamSpeakInstancesGroupRequest;
use Api\TeamspeakInstances;
use Api\GroupTeamspeakInstances;
use Illuminate\Http\Request;
use Api\Traits\RestHelperTrait;
use Api\Exceptions\RequestIsNotJson;
use Api\Http\Controllers\Controller;
use Api\Traits\RestSuccessResponseTrait;
use Api\Exceptions\GroupNotFoundException;
use Api\Exceptions\ServerNotFoundException;
use Api\Exceptions\ServerGroupExistException;
use Api\Exceptions\ServerGroupNotAssociatedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeamSpeakInstancesGroupController extends Controller {
	use RestSuccessResponseTrait;
	use RestHelperTrait;

	/**
	 * @api {get} /v1/teamspeak/instance/group Список
	 * @apiName TeamSpeak Instances Group Group list
	 * @apiGroup TeamSpeak Instances Group
	 * @apiVersion 1.0.0
	 * @apiDescription Список групп инстансов. <br/><br/>
	 * @apiSampleRequest /v1/teamspeak/instance/group
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instance.group.list
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":[
	 *    {
	 *      "slug":"athp",
	 *      "name":"ATHP"
	 *    },
	 *    {
	 *      "slug":"athp2",
	 *      "name":"ATHP2"
	 *    },
	 *    {
	 *      "slug":"servicevoice",
	 *      "name":"Service-Voice"
	 *    }
	 *  ]
	 *}
	 */
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	function List() {
		$GroupList = Group::all();

		return $this->jsonResponse( $GroupList );
	}

	/**
	 * @api {post} /v1/teamspeak/instance/group Создать
	 * @apiName TeamSpeak Instances Group Group Add
	 * @apiGroup TeamSpeak Instances Group
	 * @apiVersion 1.0.0
	 * @apiDescription Создает группу инстансов. <br/><br/>
	 * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
	 * {<br/>
	 * &nbsp; "name":"Service-Voice",<br/>
	 * &nbsp; "slug":"servicevoice", (только строчные буквы, и только латиница) <br/>
	 *}
	 * @apiSampleRequest /v1/teamspeak/instance/group
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instance.group.create
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *}
	 */
	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws RequestIsNotJson
	 */
	function Create( TeamSpeakInstancesGroupRequest $request ) {
		$Group       = new Group;
		$Group->slug = $request->input( 'slug' );
		$Group->name = $request->input( 'name' );
		$Group->saveOrFail();

		return $this->jsonResponse();
	}

	/**
	 * @api {delete} /v1/teamspeak/instance/group/:group_slug Удалить
	 * @apiName TeamSpeak Instances Group Group delete
	 * @apiGroup TeamSpeak Instances Group
	 * @apiVersion 1.0.0
	 * @apiDescription Удалить группу инстансов. <br/><br/>
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group_slug
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instance.group.delete
	 * @apiParam {String} group_slug Уникальное название группы TeamSpeak3 инстансов в API.
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *}
	 */
	/**
	 * @param string $group
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws GroupNotFoundException
	 */
	function Delete( string $group ) {
		try {
			$Group = Group::Group( $group )->firstOrFail();
		} catch ( ModelNotFoundException $e ) {
			throw new GroupNotFoundException( $group );
		}

		GroupTeamspeakInstances::GroupID( $Group->id )->delete();
		Group::Group( $group )->delete();

		return $this->jsonResponse();
	}

	/**
	 * @api {get} /v1/teamspeak/instance/group/:group_slug Список в группе
	 * @apiName TeamSpeak Instances Group Instances Group list
	 * @apiGroup TeamSpeak Instances Group
	 * @apiVersion 1.0.0
	 * @apiDescription Список инстансов состоящих в группе. <br/><br/>
	 * @apiSampleRequest /v1/teamspeak/instance/group
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instance.group.instance.list
	 * @apiParam {String} group_slug Уникальное название группы TeamSpeak3 инстансов в API.
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":[
	 *    {
	 *      "instance_id":1,
	 *    },
	 *    {
	 *      "instance_id":2,
	 *    },
	 *    {
	 *      "instance_id":3,
	 *    }
	 *  ]
	 *}
	 */
	/**
	 * @param string $group
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	function ServerGroupList( string $group ) {
		$GroupTeamSpeakInsnsesList = Group::with( 'TeamspeakInstances' )->Group( $group )->firstOrFail();
		$GroupTeamSpeakInsnsesList = $GroupTeamSpeakInsnsesList->toArray()['teamspeak_instances'];

		return $this->jsonResponse( $GroupTeamSpeakInsnsesList );
	}

	/**
	 * @api {post} /v1/teamspeak/instance/group/:group_slug/:server_id Добавить в группу
	 * @apiName TeamSpeak Instances Group Шnstance Group Add
	 * @apiGroup TeamSpeak Instances Group
	 * @apiVersion 1.0.0
	 * @apiDescription Добавить инстанс в группу. <br/><br/>
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group_slug/:server_id
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instance.group.instance.add
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *}
	 */
	/**
	 * @param string $group
	 * @param int $server_id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws GroupNotFoundException
	 * @throws ServerGroupExistException
	 * @throws ServerNotFoundException
	 */
	function ServerAddGroup( string $group, int $server_id ) {
		try {
			$Group = Group::where( 'slug', $group )->firstOrFail();
		} catch ( ModelNotFoundException $e ) {
			throw new GroupNotFoundException( $group );
		}

		try {
			$instance_id = TeamspeakInstances::where( 'id', $server_id )->firstOrFail();
		} catch ( ModelNotFoundException $e ) {
			throw new ServerNotFoundException( $server_id );
		}
		if ( GroupTeamspeakInstances::GetInstance( $server_id )->first() != null ) {
			throw new ServerGroupExistException( $server_id, $group );
		}

		$GroupTeamspeakInstances              = new GroupTeamspeakInstances;
		$GroupTeamspeakInstances->instance_id = $instance_id->id;
		$GroupTeamspeakInstances->group_id    = $Group->id;
		$GroupTeamspeakInstances->saveOrFail();

		return $this->jsonResponse( null );
	}

	/**
	 * @api {delete} /v1/teamspeak/instance/group/:group_slug/:server_id Удалить из группы
	 * @apiName TeamSpeak Instances Group Instance Group delete
	 * @apiGroup TeamSpeak Instances Group
	 * @apiVersion 1.0.0
	 * @apiDescription Удалить инстанс из группы инстансов. <br/><br/>
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group_slug/:server_id
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instance.group.instance.remove
	 * @apiParam {String} group_slug Уникальное название группы TeamSpeak3 инстансов в API.
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiUse VALIDATION_FAILED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *}
	 */
	/**
	 * @param string $group
	 * @param int $server_id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws GroupNotFoundException
	 * @throws ServerGroupNotAssociatedException
	 * @throws ServerNotFoundException
	 */
	function ServerRemoveGroup( string $group, int $server_id ) {
		try {
			$Group = Group::where( 'slug', $group )->firstOrFail();
		} catch ( ModelNotFoundException $e ) {
			throw new GroupNotFoundException( $group );
		}

		try {
			$server = TeamspeakInstances::where( 'id', $server_id )->firstOrFail();
		} catch ( ModelNotFoundException $e ) {
			throw new ServerNotFoundException( $server_id );
		}

		$GroupServer = GroupTeamspeakInstances::GetInstance( $server_id )->first();

		if ( $GroupServer === null ) {
			throw new ServerGroupNotAssociatedException( $server_id, $group );
		}

		GroupTeamspeakInstances::GetInstance( $server_id )->delete();

		return $this->jsonResponse( null );

	}
}