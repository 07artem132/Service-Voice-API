<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 02.08.2017
 * Time: 16:33
 */

namespace Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;


class TeamSpeakVirtualServerChannelController extends Controller
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
     * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel Список
     * @apiName Get list all channel virtual server
     * @apiGroup Virtual Server Channel
     * @apiVersion 1.0.0
     * @apiDescription Возврашает список каналов созданных на виртуальном сервере
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiSuccess (Success code 200) {Object}  data  Содержит запрашиваемую информацию.
     * @apiPermission api.teamspeak.virtualserver.channel.list
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "1934":{
     *      "cid":1934,
     *      "pid":0,
     *      "channel_order":0,
     *      "channel_name":"Default Channel",
     *      "channel_topic":"Default Channel has no topic",
     *      "channel_flag_default":1,
     *      "channel_flag_password":0,
     *      "channel_flag_permanent":1,
     *      "channel_flag_semi_permanent":0,
     *      "channel_codec":4,
     *      "channel_codec_quality":6,
     *      "channel_needed_talk_power":0,
     *      "channel_icon_id":0,
     *      "total_clients_family":2,
     *      "channel_maxclients":-1,
     *      "channel_maxfamilyclients":-1,
     *      "total_clients":2,
     *      "channel_needed_subscribe_power":0
     *    },
     *    "1935":{
     *      "cid":1935,
     *      "pid":0,
     *      "channel_order":1934,
     *      "channel_name":"12321",
     *      "channel_topic":"",
     *      "channel_flag_default":0,
     *      "channel_flag_password":0,
     *      "channel_flag_permanent":1,
     *      "channel_flag_semi_permanent":0,
     *      "channel_codec":4,
     *      "channel_codec_quality":5,
     *      "channel_needed_talk_power":0,
     *      "channel_icon_id":0,
     *      "total_clients_family":0,
     *      "channel_maxclients":-1,
     *      "channel_maxfamilyclients":-1,
     *      "total_clients":0,
     *      "channel_needed_subscribe_power":0
     *    }
     *  }
     *}
     */
    /**
     * @param int $instance_id
     * @param string $bashe64uid
     * @return JsonResponse
     */
    function List(int $instance_id, string $bashe64uid): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);

        $TeamSpeak = new TeamSpeak($this->instance_id, $this->uid);
        $data = $TeamSpeak->VirtualServerChannelList();
        return $this->jsonResponse($data);
    }

    /**
     * @api {POST} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel Создать
     * @apiName Create channel virtual server
     * @apiGroup Virtual Server Channel
     * @apiVersion 1.0.0
     * @apiDescription Создает канал и возврашает id канала на виртуальном сервере <br/><br/>
     * <b>Вы можете передать следуюшие параметры:</b><br/>
     *  channel_name (Обязательный параметр) <br/>
     *  channel_topic<br/>
     *  channel_description<br/>
     *  channel_password<br/>
     *  channel_codec<br/>
     *  channel_codec_quality<br/>
     *  channel_maxclients<br/>
     *  channel_maxfamilyclients<br/>
     *  channel_order<br/>
     *  channel_flag_permanent<br/>
     *  channel_flag_semi_permanent<br/>
     *  channel_flag_temporary<br/>
     *  channel_flag_default<br/>
     *  channel_flag_maxclients_unlimited<br/>
     *  channel_flag_maxfamilyclients_unlimited<br/>
     *  channel_flag_maxfamilyclients_inherited<br/>
     *  channel_needed_talk_power<br/>
     *  channel_name_phonetic<br/>
     *  channel_icon_id<br/>
     *  channel_codec_is_unencrypted<br/>
     *  cpid<br/>
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiSuccess (Success code 200) {Object}  data  Содержит запрашиваемую информацию.
     * @apiPermission api.teamspeak.virtualserver.channel.list
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "cid":1939
     *  }
     *}
     */
    /**
     * @param Request $request
     * @param int $instance_id
     * @param string $bashe64uid
     * @return JsonResponse
     */
    function Create(Request $request, int $instance_id, string $bashe64uid): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);

        if (!$request->isJson())
            throw new RequestIsNotJson();

        $rules = config('ApiValidation.TeamSpeak.VirtualServer.channel.create.rules');
        $messages = config('ApiValidation.TeamSpeak.VirtualServer.channel.create.messages');

        $this->validate($request, $rules, $messages);

        $TeamSpeak = new TeamSpeak($this->instance_id, $this->uid);
        $data['cid'] = $TeamSpeak->VirtualServerChannelCreate($request->all());

        return $this->jsonResponse($data);
    }

    /**
     * @api {delete} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel/:channelid Удалить
     * @apiName delete channel virtual server from channelid
     * @apiGroup Virtual Server Channel
     * @apiVersion 1.0.0
     * @apiDescription Удаляет канал и все его под каналы на виртуальном сервере
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel/:channelid
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} channelid Уникальный ID канала на TeamSpeak3 инстансе.
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiSuccess (Success code 200) {Object}  data  Содержит запрашиваемую информацию.
     * @apiPermission api.teamspeak.virtualserver.channel.info
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
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
     * @param $channelid
     * @return JsonResponse
     */
    function Delete(int $instance_id, string $bashe64uid, int $channelid): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);
        $this->channel_id = $channelid;

        $TeamSpeak = new TeamSpeak($this->instance_id, $this->uid);
        $data = $TeamSpeak->VirtualServerChannelDelete($this->channel_id);
        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel/:channelid/info Детальная информация
     * @apiName Get info channel virtual server from channelid
     * @apiGroup Virtual Server Channel
     * @apiVersion 1.0.0
     * @apiDescription Возврашает подробную информацию о канале на виртуальном сервере
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel/:channelid/info
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} channelid Уникальный ID канала на TeamSpeak3 инстансе.
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiSuccess (Success code 200) {Object}  data  Содержит запрашиваемую информацию.
     * @apiPermission api.teamspeak.virtualserver.channel.info
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "pid":"0",
     *    "channel_name":"Default Channel",
     *    "channel_topic":"Default Channel has no topic",
     *    "channel_description":"This is the default channel",
     *    "channel_password":"",
     *    "channel_codec":"4",
     *    "channel_codec_quality":"6",
     *    "channel_maxclients":"-1",
     *    "channel_maxfamilyclients":"-1",
     *    "channel_order":"0",
     *    "channel_flag_permanent":"1",
     *    "channel_flag_semi_permanent":"0",
     *    "channel_flag_default":"1",
     *    "channel_flag_password":"0",
     *    "channel_codec_latency_factor":"1",
     *    "channel_codec_is_unencrypted":"1",
     *    "channel_security_salt":"",
     *    "channel_delete_delay":"0",
     *    "channel_flag_maxclients_unlimited":"1",
     *    "channel_flag_maxfamilyclients_unlimited":"1",
     *    "channel_flag_maxfamilyclients_inherited":"0",
     *    "channel_filepath":"files\/virtualserver_219\/channel_1934",
     *    "channel_needed_talk_power":"0",
     *    "channel_forced_silence":"0",
     *    "channel_name_phonetic":"",
     *    "channel_icon_id":"0",
     *    "channel_flag_private":"0",
     *    "seconds_empty":"-1"
     *  }
     *}
     */
    /**
     * @param int $instance_id
     * @param string $bashe64uid
     * @param $channelid
     * @return JsonResponse
     */
    function Info(int $instance_id, string $bashe64uid, int $channelid): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);
        $this->channel_id = $channelid;

        $TeamSpeak = new TeamSpeak($this->instance_id, $this->uid);
        $data = $TeamSpeak->VirtualServerChannelInfo($this->channel_id);
        return $this->jsonResponse($data);
    }

    /**
     * @api {PUT} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel/:channelid/move Переместить в под канал
     * @apiName channel move to sub channel virtual server
     * @apiGroup Virtual Server Channel
     * @apiVersion 1.0.0
     * @apiDescription Перемешает канал в под канал и устанавливает позицию канала в под канале <br/><br/>
     * <b>Вы можете передать следуюшие параметры:</b><br/>
     *  channel_parent_id (Обязательный параметр) <br/>
     *  channel_sort_order (Обязательный параметр) <br/>
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} channelid Уникальный ID канала на TeamSpeak3 инстансе.
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.channel.move
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
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
     * @param Request $request
     * @param int $instance_id
     * @param string $bashe64uid
     * @param $channelid
     * @return JsonResponse
     */
    function Move(Request $request, int $instance_id, string $bashe64uid, int $channelid): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);

        if (!$request->isJson())
            throw new RequestIsNotJson();

        $rules = config('ApiValidation.TeamSpeak.VirtualServer.channel.move.rules');
        $messages = config('ApiValidation.TeamSpeak.VirtualServer.channel.move.messages');

        $this->validate($request, $rules, $messages);

        $TeamSpeak = new TeamSpeak($this->instance_id, $this->uid);
        $TeamSpeak->VirtualServerChannelMove($channelid, $request->all());

        return $this->jsonResponse(null);
    }

    /**
     * @api {PUT} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel/:channelid Изменить
     * @apiName Edit channel virtual server
     * @apiGroup Virtual Server Channel
     * @apiVersion 1.0.0
     * @apiDescription Изменяет канал <br/><br/>
     * <b>Вы можете передать следуюшие параметры:</b><br/>
     *  channel_name <br/>
     *  channel_topic<br/>
     *  channel_description<br/>
     *  channel_password<br/>
     *  channel_codec<br/>
     *  channel_codec_quality<br/>
     *  channel_maxclients<br/>
     *  channel_maxfamilyclients<br/>
     *  channel_order<br/>
     *  channel_flag_permanent<br/>
     *  channel_flag_semi_permanent<br/>
     *  channel_flag_temporary<br/>
     *  channel_flag_default<br/>
     *  channel_flag_maxclients_unlimited<br/>
     *  channel_flag_maxfamilyclients_unlimited<br/>
     *  channel_flag_maxfamilyclients_inherited<br/>
     *  channel_needed_talk_power<br/>
     *  channel_name_phonetic<br/>
     *  channel_icon_id<br/>
     *  channel_codec_is_unencrypted<br/>
     *  cpid<br/>
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/channel
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} channelid Уникальный ID канала на TeamSpeak3 инстансе.
     * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiSuccess (Success code 200) {Object}  data  Содержит запрашиваемую информацию.
     * @apiPermission api.teamspeak.virtualserver.channel.list
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
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
     * @param Request $request
     * @param int $instance_id
     * @param string $bashe64uid
     * @param int $channelid
     * @return JsonResponse
     */
    function Edit(Request $request, int $instance_id, string $bashe64uid, int $channelid): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);

        if (!$request->isJson())
            throw new RequestIsNotJson();

        $rules = config('ApiValidation.TeamSpeak.VirtualServer.channel.edit.rules');
        $messages = config('ApiValidation.TeamSpeak.VirtualServer.channel.edit.messages');

        $this->validate($request, $rules, $messages);

        $TeamSpeak = new TeamSpeak($this->instance_id, $this->uid);
        $TeamSpeak->VirtualServerChannelEdit($channelid, $request->all());

        return $this->jsonResponse(null);
    }

}