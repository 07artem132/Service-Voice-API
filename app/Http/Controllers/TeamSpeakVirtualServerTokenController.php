<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 03.08.2017
 * Time: 15:18
 */

namespace Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;
use Api\Http\Requests\TeamSpeakVirtualServerTokenCreateRequest as TokenCreateRequest;

class TeamSpeakVirtualServerTokenController
{
    use RestSuccessResponseTrait;

    /**
     * @var int Уникальный идентификатор сервера
     */
    private $instance_id;
    /**
     * @var string Уникальный идентификатор виртуального сервера
     */
    private $uid;
    /**
     * @var int Токен (Который используется для получения прав на виртуальном TeamSpeak 3 сервере)
     */
    private $token;

    /**
     * @api {delete} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/token/:bashe64token Удалить
     * @apiName TeamSpeak 3 token delete
     * @apiGroup Virtual Server Token
     * @apiVersion 1.0.0
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {String} bashe64token Токен который необходимо удалить закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/token/:bashe64token
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.token.delete
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
     * @param int $instance_id
     * @param string $bashe64uid
     * @param string $bashe64token
     * @return JsonResponse
     */
    function Delete(int $instance_id, string $bashe64uid, string $bashe64token): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);
        $this->token = base64_decode($bashe64token);

        $ts3conn = new TeamSpeak($this->instance_id, $this->uid);
        $ts3conn->VirtualServerTokenDelete($this->token);

        return $this->jsonResponse(null);
    }

    /**
     * @api {post} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/token Создать
     * @apiName TeamSpeak 3 token create
     * @apiGroup Virtual Server Token
     * @apiVersion 1.0.0
     * @apiDescription Создает токен на  виртуальном TeamSpeak 3 сервере для переданной группы<br/><br/>
     * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
     *{<br/>
     *&nbsp;"groupID":796,<br/>
     *&nbsp;"description":"123" (не обязательное значение)<br/>
     *}<br/>
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/token
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.token.delete
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status": "success",
     *  "data": "xCkHO240Zx34ivLWD46XzinLrLqNCijRzvTj7CnJ"
     *}
     */
    /**
     * @param int $instance_id
     * @param string $bashe64uid
     * @param TokenCreateRequest $requert
     * @return JsonResponse
     */
    function Create(int $instance_id, string $bashe64uid, TokenCreateRequest $requert): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);

        $ts3conn = new TeamSpeak($this->instance_id, $this->uid);
        $data = $ts3conn->VirtualServerTokenCreate($requert->input('groupID'), $requert->input('groupID', null));

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/token Список
     * @apiName TeamSpeak 3 token list
     * @apiGroup Virtual Server Token
     * @apiVersion 1.0.0
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/token
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.token.list
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "EPxIx3SUjB60tYX3gg6IQL80TffCzI32cjE5F8oD":{
     *      "token":"EPxIx3SUjB60tYX3gg6IQL80TffCzI32cjE5F8oD",
     *      "token_type":"0",
     *      "token_id1":"796",
     *      "token_id2":"0",
     *      "token_created":"1506864485",
     *      "token_description":"796"
     *    },
     *    "xCkHO240Zx34ivLWD46XzinLrLqNCijRzvTj7CnJ":{
     *      "token":"xCkHO240Zx34ivLWD46XzinLrLqNCijRzvTj7CnJ",
     *      "token_type":"0",
     *      "token_id1":"796",
     *      "token_id2":"0",
     *      "token_created":"1506864488",
     *      "token_description":"796"
     *    }
     *  }
     *}
     */
    /**
     * @param int $instance_id
     * @param string $bashe64uid
     * @return JsonResponse Ответ
     */
    function List(int $instance_id, string $bashe64uid): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);

        $ts3conn = new TeamSpeak($this->instance_id, $this->uid);
        $data = $ts3conn->VirtualServerTokenlList();

        return $this->jsonResponse($data);
    }
}