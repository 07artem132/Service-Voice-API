<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 25.07.2017
 * Time: 18:48
 */

namespace Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Api\Exceptions\RequestIsNotJson;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;

class TeamSpeakVirtualServerBanControllers extends Controller
{
    use RestSuccessResponseTrait;

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban Список банов
     * @apiName TeamSpeak 3 ban list
     * @apiGroup Virtual Server ban
     * @apiVersion 1.0.0
     * @apiDescription Возврашает все сушествуюшие баны на виртуальном TeamSpeak 3 сервере
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.ban.list
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "5":{
     *      "banid":"5",
     *      "ip":"",
     *      "name":"123",
     *      "uid":"",
     *      "lastnickname":"",
     *      "created":"1500998088",
     *      "duration":"0",
     *      "invokername":"serveradmin from 92.63.203.176:16424",
     *      "invokercldbid":"1",
     *      "invokeruid":"serveradmin",
     *      "reason":"123",
     *      "enforcements":"0"
     *    }
     *  }
     *}
     */
    /**
     * @param int $server_id
     * @param string $bashe64uid
     * @return JsonResponse
     */
    function List(int $server_id, string $bashe64uid): JsonResponse
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new TeamSpeak($server_id, $uid);

        $data = $ts3conn->VirtualServerBanList();

        return $this->jsonResponse($data);
    }

    /**
     * @api {post} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban Создать бан
     * @apiName TeamSpeak 3 ban create
     * @apiGroup Virtual Server ban
     * @apiVersion 1.0.0
     * @apiDescription Создает бан на  виртуальном TeamSpeak 3 сервере <br/><br/>
     * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
     *{<br/>
     *&nbsp;"rules":{<br/>
     * &nbsp;&nbsp;&nbsp;"name":"*",<br/>
     * &nbsp;&nbsp;&nbsp;"ip":"127.0.0.*",<br/>
     * &nbsp;&nbsp;&nbsp;"uid":"fadsfwqerqvasdf"<br/>
     *&nbsp;&nbsp;},<br/>
     *&nbsp;"timeseconds":111111,<br/>
     *&nbsp;"reason":"123"<br/>
     *}<br/>
     * В rules минимум 1 параметр
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.ban.list
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
     * @param int $server_id
     * @param string $bashe64uid
     * @return JsonResponse
     */
    function Create(Request $request, int $server_id, string $bashe64uid): JsonResponse
    {
        if (!$request->isJson())
            throw new RequestIsNotJson();

        $rules = config('ApiValidation.TeamSpeak.VirtualServer.Ban.rules');
        $messages = config('ApiValidation.TeamSpeak.VirtualServer.Ban.messages');

        $this->validate($request, $rules, $messages);

        $uid = base64_decode($bashe64uid);
        $ts3conn = new TeamSpeak($server_id, $uid);

        $ts3conn->VirtualServerBanCreate(
            $request->input('rules'),
            $request->input('timeseconds'),
            $request->input('reason')
        );

        return $this->jsonResponse(null);
    }

    /**
     * @api {delete} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban/:banid Удалить бан
     * @apiName TeamSpeak 3 ban delete
     * @apiGroup Virtual Server ban
     * @apiVersion 1.0.0
     * @apiDescription Удаляет бан по banid на виртуальном TeamSpeak 3 сервере
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} banid Уникальный ID бана для виртуального TeamSpeak3 сервера.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban/:banid
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.ban.delete
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
     * @param int $server_id
     * @param string $bashe64uid
     * @param int $banid
     * @return JsonResponse
     */
    function Delete(int $server_id, string $bashe64uid, int $banid): JsonResponse
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new TeamSpeak($server_id, $uid);

        $ts3conn->VirtualServerBanDelete($banid);

        return $this->jsonResponse(null);
    }

    /**
     * @api {delete} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban Очистить список банов
     * @apiName TeamSpeak 3 ban all delete
     * @apiGroup Virtual Server ban
     * @apiVersion 1.0.0
     * @apiDescription Удаляет все баны на виртуальном TeamSpeak 3 сервере
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/ban
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.ban.clear
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
     * @param int $server_id
     * @param string $bashe64uid
     * @return JsonResponse
     */
    function ListClear(int $server_id, string $bashe64uid): JsonResponse
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new TeamSpeak($server_id, $uid);

        $ts3conn->VirtualServerBanListClear();
        return $this->jsonResponse(null);
    }

}