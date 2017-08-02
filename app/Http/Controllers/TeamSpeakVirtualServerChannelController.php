<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 02.08.2017
 * Time: 16:33
 */

namespace Api\Http\Controllers;

use Api\SnapshotsTeamspeakVirtualServers;
use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;

class TeamSpeakVirtualServerChannelController
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
    function List(int $instance_id, string $bashe64uid)
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);

        $TeamSpeak = new TeamSpeak($this->instance_id,$this->uid);
        $data = $TeamSpeak->VirtualServerChannelList();
        return $this->jsonResponse($data);
    }

    function Create()
    {
    }

    function Delete()
    {
    }

    function Info()
    {
    }

    function move()
    {
    }

    function Find()
    {
    }

    function Edit()
    {
    }

}