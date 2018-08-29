<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 24.07.2017
 * Time: 18:35
 */

namespace Api\Http\Controllers;

use Api\Http\Requests\TeamSpeakInstanseEditRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Api\Exceptions\RequestIsNotJson;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;

class TeamSpeakInstanseController extends Controller
{
    use RestSuccessResponseTrait;

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/hostinfo Общая информация
     * @apiName TeamSpeak 3 instance hostinfo
     * @apiGroup Instance
     * @apiVersion 1.0.0
     * @apiDescription Отображает подробную информацию о подключении к экземпляру сервера, включая время работы, количество виртуальных Серверы онлайн, информация о трафике и т. Д.
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/hostinfo
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.hostinfo
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
     *      "instance_uptime":3437537,
     *      "host_timestamp_utc":1501172267,
     *      "virtualservers_running_total":210,
     *      "virtualservers_total_maxclients":7212,
     *      "virtualservers_total_clients_online":5,
     *      "virtualservers_total_channels_online":231,
     *      "connection_filetransfer_bandwidth_sent":0,
     *      "connection_filetransfer_bandwidth_received":0,
     *      "connection_filetransfer_bytes_sent_total":9559110,
     *      "connection_filetransfer_bytes_received_total":6976349,
     *      "connection_packets_sent_total":109432015,
     *      "connection_bytes_sent_total":11047963897,
     *      "connection_packets_received_total":83518741,
     *      "connection_bytes_received_total":8045676214,
     *      "connection_bandwidth_sent_last_second_total":6157,
     *      "connection_bandwidth_sent_last_minute_total":11005,
     *      "connection_bandwidth_received_last_second_total":6167,
     *      "connection_bandwidth_received_last_minute_total":10945
     *    }
     *  ]
     *}
     */
    /**
     * @param int $server_id
     * @return JsonResponse
     */
    function HostInfo(int $server_id): JsonResponse
    {
        $ts3conn = new TeamSpeak($server_id);

        $data = $ts3conn->hostinfo();

        return $this->jsonResponse($data);
    }

    /**
     * @api {put} /v1/teamspeak/instance/:server_id/edit Изменение конфигурации
     * @apiName TeamSpeak 3 instance edit
     * @apiGroup Instance
     * @apiVersion 1.0.0
     * @apiDescription Изменяет конфигурацию инстанса с использованием заданных свойств. <br/><br/>
     * <b> Доступные значения: </b><br/>
     * serverinstance_ guest_serverquery_group <br/>
     * serverinstance_template_serveradmin_group <br/>
     * serverinstance_filetransfer_port <br/>
     * serverinstance_max_download_total_bandwitdh <br/>
     * serverinstance_max_upload_total_bandwitdh <br/>
     * serverinstance_template_serverdefault_group <br/>
     * serverinstance_template_channeldefault_group <br/>
     * serverinstance_template_channeladmin_group <br/>
     * serverinstance_serverquery_flood_commands <br/>
     * serverinstance_serverquery_flood_time <br/>
     * serverinstance_serverquery_flood_ban_time <br/>
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/edit
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.edit
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
     * @param int $server_id
     * @return JsonResponse
     * @throws RequestIsNotJson
     */
    function Edit(TeamSpeakInstanseEditRequest $request, int $server_id): JsonResponse
    {
        $ts3conn = new TeamSpeak($server_id);

        $ts3conn->instanceedit($request->all());

        return $this->jsonResponse(null);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/bindinglist Прослушиваемые IP
     * @apiName TeamSpeak 3 instance Bind List
     * @apiGroup Instance
     * @apiVersion 1.0.0
     * @apiDescription Отображает информацию о том какие IP адреса прослушиваются.
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/bindinglist
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.bindinglist
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "ip":"0.0.0.0"
     *  }
     *}
     */
    /**
     * @param int $server_id
     * @return JsonResponse
     */
    function BindList(int $server_id): JsonResponse
    {
        $ts3conn = new TeamSpeak($server_id);

        $data = $ts3conn->bindinglist();

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/instanceinfo Конфигурация
     * @apiName TeamSpeak 3 instance info
     * @apiGroup Instance
     * @apiVersion 1.0.0
     * @apiDescription Отображает конфигурацию экземпляра сервера, включая номер версии базы данных, порт передачи файлов, значение по умолчанию Идентификаторы групп и т. Д.
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/instanceinfo
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.instanceinfo
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
     *      "serverinstance_database_version":26,
     *      "serverinstance_filetransfer_port":54070,
     *      "serverinstance_max_download_total_bandwidth":-1,
     *      "serverinstance_max_upload_total_bandwidth":-1,
     *      "serverinstance_guest_serverquery_group":1,
     *      "serverinstance_serverquery_flood_commands":50,
     *      "serverinstance_serverquery_flood_time":3,
     *      "serverinstance_serverquery_ban_time":600,
     *      "serverinstance_template_serveradmin_group":3,
     *      "serverinstance_template_serverdefault_group":5,
     *      "serverinstance_template_channeladmin_group":1,
     *      "serverinstance_template_channeldefault_group":4,
     *      "serverinstance_permissions_version":19,
     *      "serverinstance_pending_connections_per_ip":0
     *    }
     *  ]
     *}
     */
    /**
     * @param int $server_id
     * @return JsonResponse
     */
    function InstanceInfo(int $server_id): JsonResponse
    {
        $ts3conn = new TeamSpeak($server_id);

        $data = $ts3conn->instanceinfo();

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/version Версия
     * @apiName TeamSpeak 3 instance Version
     * @apiGroup Instance
     * @apiVersion 1.0.0
     * @apiDescription Отображает информацию о версии сервера, включая номер платформы и сборки.
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/instanceinfo
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.version
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "version":"3.0.13.6",
     *    "build":"1478594913",
     *    "platform":"Linux"
     *  }
     *}
     */
    /**
     * @param int $server_id
     * @return JsonResponse
     */
    function Version(int $server_id): JsonResponse
    {
        $ts3conn = new TeamSpeak($server_id);

        $data = $ts3conn->version();

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/serverlist Список виртуальных серверов
     * @apiName TeamSpeak 3 instance list
     * @apiGroup Instance
     * @apiVersion 1.0.0
     * @apiDescription Отображает список виртуальных серверов, включая их идентификатор, статус, количество клиентов в Интернете и т. Д.
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/serverlist
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.serverlist
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "10":{
     *      "virtualserver_id":10,
     *      "virtualserver_port":9989,
     *      "virtualserver_status":"online",
     *      "virtualserver_clientsonline":0,
     *      "virtualserver_queryclientsonline":0,
     *      "virtualserver_maxclients":32,
     *      "virtualserver_uptime":3438381,
     *      "virtualserver_name":"TeamSpeak ]I[ Server",
     *      "virtualserver_autostart":1,
     *      "virtualserver_machine_id":1,
     *      "virtualserver_unique_identifier":"VciOq4+TUj2dMn3ACC3yQwYrOFA="
     *    },
     *    "12":{
     *      "virtualserver_id":12,
     *      "virtualserver_port":9990,
     *      "virtualserver_status":"online",
     *      "virtualserver_clientsonline":0,
     *      "virtualserver_queryclientsonline":0,
     *      "virtualserver_maxclients":50,
     *      "virtualserver_uptime":1572170,
     *      "virtualserver_name":"123 ",
     *      "virtualserver_autostart":1,
     *      "virtualserver_machine_id":1,
     *      "virtualserver_unique_identifier":"wc/gBF2jcFjuKOGsBwl4OlR3FXY="
     *    }
     *  }
     *}
     */
    /**
     * @param int $server_id
     * @return JsonResponse
     */
    function ServerList(int $server_id): JsonResponse
    {
        $ts3conn = new TeamSpeak($server_id);

        $data = $ts3conn->serverlist();

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/log/:last_pos Лог инстанса
     * @apiName TeamSpeak 3 instance log
     * @apiGroup Instance
     * @apiVersion 1.0.0
     * @apiDescription Возврашает лог TeamSpeak 3 инстанса
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {Number} last_pos Позиция для считывания лога (При первом запросе укажите 0, это означает самое начало).
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/log/:last_pos
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.log
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "last_pos":17248891,
     *    "file_size":17260198,
     *    "log":[
     *      {
     *        "timestamp":1501164782,
     *        "level":4,
     *        "channel":"Query",
     *        "server_id":"",
     *        "msg":"query from 60 92.63.203.28:39302 issued: logout",
     *        "msg_plain":"2017-07-27 17:13:02.190252|INFO    |Query         |   |query from 60 92.63.203.28:39302 issued: logout",
     *        "malformed":false
     *      },
     *      {
     *        "timestamp":1501164782,
     *        "level":4,
     *        "channel":"Query",
     *        "server_id":"",
     *        "msg":"query from 455 92.63.203.28:39304 issued: login with account \"serveradmin\"(serveradmin)",
     *        "msg_plain":"2017-07-27 17:13:02.203541|INFO    |Query         |   |query from 455 92.63.203.28:39304 issued: login with account \"serveradmin\"(serveradmin)",
     *        "malformed":false
     *      },
     *      {
     *        "timestamp":1501164782,
     *        "level":4,
     *        "channel":"Query",
     *        "server_id":"",
     *        "msg":"query from 455 92.63.203.28:39304 issued: serverlist -uid",
     *        "msg_plain":"2017-07-27 17:13:02.218596|INFO    |Query         |   |query from 455 92.63.203.28:39304 issued: serverlist -uid",
     *        "malformed":false
     *      }
     *    ]
     *  }
     *}
     */
    /**
     * @param int $server_id
     * @param int $last_pos
     * @return JsonResponse
     */
    function GetLog(int $server_id, int $last_pos)
    {
        $ts3conn = new TeamSpeak($server_id);

        $data = $ts3conn->GetInstanseLog($last_pos);

        return $this->jsonResponse($data);
    }
}