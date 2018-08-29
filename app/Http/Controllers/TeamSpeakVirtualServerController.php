<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 24.07.2017
 * Time: 16:21
 */

namespace Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;
use Api\Http\Requests\TeamSpeakVirtualServerCreateRequest;

/**
 * Class TeamSpeakVirtualServerController
 * @package Api\Http\Controllers
 */
class TeamSpeakVirtualServerController extends Controller {
	use RestSuccessResponseTrait;
	private $ts3conn;
	private $uid;
	/**
	 * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/create Создание сервера
	 * @apiName TeamSpeak 3 create server
	 * @apiGroup Virtual Server
	 * @apiVersion 1.0.0
	 * @apiDescription Создает TeamSpeak 3 сервер и возврашает sid,token,virtualserver_port. <br/><br/>
	 * Возможные параметры:
	 *  virtualserver_name (Обязательный) <br/>
	 *  virtualserver_welcomemessage <br/>
	 *  virtualserver_maxclients (Обязательный) <br/>
	 *  virtualserver_password <br/>
	 *  virtualserver_hostmessage <br/>
	 *  virtualserver_hostmessage_mode <br/>
	 *  virtualserver_default_server_group <br/>
	 *  virtualserver_default_channel_group <br/>
	 *  virtualserver_default_channel_admin_group <br/>
	 *  virtualserver_max_download_total_bandwidth <br/>
	 *  virtualserver_max_upload_total_bandwidth <br/>
	 *  virtualserver_hostbanner_url <br/>
	 *  virtualserver_hostbanner_gfx_url <br/>
	 *  virtualserver_hostbanner_gfx_interval <br/>
	 *  virtualserver_complain_autoban_count <br/>
	 *  virtualserver_complain_autoban_time <br/>
	 *  virtualserver_complain_remove_time <br/>
	 *  virtualserver_min_clients_in_channel_before_forced_silence <br/>
	 *  virtualserver_priority_speaker_dimm_modificator <br/>
	 *  virtualserver_antiflood_points_tick_reduce <br/>
	 *  virtualserver_antiflood_points_needed_command_block <br/>
	 *  virtualserver_antiflood_points_needed_ip_block <br/>
	 *  virtualserver_hostbanner_mode <br/>
	 *  virtualserver_hostbutton_tooltip <br/>
	 *  virtualserver_hostbutton_gfx_url <br/>
	 *  virtualserver_hostbutton_url <br/>
	 *  virtualserver_download_quota <br/>
	 *  virtualserver_upload_quota <br/>
	 *  virtualserver_machine_id <br/>
	 *  virtualserver_port <br/>
	 *  virtualserver_autostart <br/>
	 *  virtualserver_log_client <br/>
	 *  virtualserver_log_query <br/>
	 *  virtualserver_log_channel <br/>
	 *  virtualserver_log_permissions <br/>
	 *  virtualserver_log_server <br/>
	 *  virtualserver_log_filetransfer <br/>
	 *  virtualserver_min_client_version <br/>
	 *  virtualserver_needed_identity_security_level <br/>
	 *  virtualserver_name_phonetic <br/>
	 *  virtualserver_icon_id <br/>
	 *  virtualserver_reserved_slots <br/>
	 *  virtualserver_weblist_enabled <br/>
	 *  virtualserver_codec_encryption_mode <br/>
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiSampleRequest /teamspeak/instance/:server_id/virtualserver/create
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiHeader {String} Content-Type  Установите значение "application/json" потому как ожидается что вы отправите json
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.virtualserver.create
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":{
	 *    "sid":218,
	 *    "token":"Z2R+CIHcJQ7qavfabysTMkAfgQ2GwHkbQGNPzCRB",
	 *    "virtualserver_port":50203
	 *  }
	 *}
	 */

	/**
	 * @param TeamSpeakVirtualServerCreateRequest $request
	 * @param int $server_id
	 *
	 * @return JsonResponse
	 */
	function Create( TeamSpeakVirtualServerCreateRequest $request, int $server_id ): JsonResponse {
		$this->ts3conn = new TeamSpeak( $server_id );

		$data = $this->ts3conn->VirtualServerCreate( $request->all() );

		return $this->jsonResponse( $data );
	}

	/**
	 * @api {delete} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/delete Удаление сервера
	 * @apiName TeamSpeak 3 Delete server
	 * @apiGroup Virtual Server
	 * @apiVersion 1.0.0
	 * @apiDescription Удаляет TeamSpeak 3 сервер
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
	 * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/delete
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.virtualserver.delete
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
	 *
	 * @return JsonResponse
	 */
	function Delete( int $server_id, string $bashe64uid ): JsonResponse {
		$this->uid = base64_decode( $bashe64uid );

		$this->ts3conn = new TeamSpeak( $server_id, $this->uid );

		$this->ts3conn->VirtualServerStop();
		$this->ts3conn->VirtualServerDelete();

		return $this->jsonResponse( null );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/stop Остановить сервера
	 * @apiName TeamSpeak 3 stop server
	 * @apiGroup Virtual Server
	 * @apiVersion 1.0.0
	 * @apiDescription Останавливает TeamSpeak 3 сервер
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
	 * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/stop
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.virtualserver.stop
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
	 *
	 * @return JsonResponse
	 */
	function Stop( int $server_id, string $bashe64uid ): JsonResponse {
		$this->uid = base64_decode( $bashe64uid );

		$this->ts3conn = new TeamSpeak( $server_id, $this->uid );

		$this->ts3conn->VirtualServerStop();

		return $this->jsonResponse( null );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/start Запуск сервера
	 * @apiName TeamSpeak 3 start server
	 * @apiGroup Virtual Server
	 * @apiVersion 1.0.0
	 * @apiDescription Запускает TeamSpeak 3 сервер
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
	 * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/start
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.virtualserver.start
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
	 *
	 * @return JsonResponse
	 */
	function Start( int $server_id, string $bashe64uid ): JsonResponse {
		$this->uid = base64_decode( $bashe64uid );

		$this->ts3conn = new TeamSpeak( $server_id, $this->uid );

		$this->ts3conn->VirtualServerStart();

		return $this->jsonResponse( null );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/log/:last_pos Лог сервера
	 * @apiName TeamSpeak 3 log server
	 * @apiGroup Virtual Server
	 * @apiVersion 1.0.0
	 * @apiDescription Возврашает лог TeamSpeak 3 сервера
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
	 * @apiParam {Number} last_pos Позиция для считывания лога (При первом запросе укажите 0, это означает самое начало).
	 * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/log/:last_pos
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.virtualserver.log
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":{
	 *    "last_pos":0,
	 *    "file_size":1132,
	 *    "log":[
	 *      {
	 *        "timestamp":1500919398,
	 *        "level":4,
	 *        "channel":"VirtualServer",
	 *        "server_id":"219",
	 *        "msg":"listening on",
	 *        "msg_plain":"2017-07-24 21:03:18.598743|INFO    |VirtualServer |219|listening on ",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919398,
	 *        "level":2,
	 *        "channel":"VirtualServer",
	 *        "server_id":"219",
	 *        "msg":"--------------------------------------------------------",
	 *        "msg_plain":"2017-07-24 21:03:18.603170|WARNING |VirtualServer |219|--------------------------------------------------------",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919398,
	 *        "level":2,
	 *        "channel":"VirtualServer",
	 *        "server_id":"219",
	 *        "msg":"ServerAdmin privilege key created, please use the line below",
	 *        "msg_plain":"2017-07-24 21:03:18.603265|WARNING |VirtualServer |219|ServerAdmin privilege key created, please use the line below",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919398,
	 *        "level":2,
	 *        "channel":"VirtualServer",
	 *        "server_id":"219",
	 *        "msg":"token=LA7h6J2lFmlCeOPyRfifR0OvD9SSCBX8Q1qCWD1g",
	 *        "msg_plain":"2017-07-24 21:03:18.603307|WARNING |VirtualServer |219|token=LA7h6J2lFmlCeOPyRfifR0OvD9SSCBX8Q1qCWD1g",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919398,
	 *        "level":2,
	 *        "channel":"VirtualServer",
	 *        "server_id":"219",
	 *        "msg":"--------------------------------------------------------",
	 *        "msg_plain":"2017-07-24 21:03:18.603344|WARNING |VirtualServer |219|--------------------------------------------------------",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919403,
	 *        "level":4,
	 *        "channel":"Query",
	 *        "server_id":"219",
	 *        "msg":"query from 60 92.63.203.176:10148 issued: serverinfo",
	 *        "msg_plain":"2017-07-24 21:03:23.163582|INFO    |Query         |219|query from 60 92.63.203.176:10148 issued: serverinfo",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919404,
	 *        "level":4,
	 *        "channel":"Query",
	 *        "server_id":"219",
	 *        "msg":"query from 60 92.63.203.176:10148 issued: servergrouplist",
	 *        "msg_plain":"2017-07-24 21:03:24.145531|INFO    |Query         |219|query from 60 92.63.203.176:10148 issued: servergrouplist",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919404,
	 *        "level":4,
	 *        "channel":"Query",
	 *        "server_id":"219",
	 *        "msg":"query from 60 92.63.203.176:10148 issued: logview lines=100 reverse=0 instance=0 begin_pos=0",
	 *        "msg_plain":"2017-07-24 21:03:24.629042|INFO    |Query         |219|query from 60 92.63.203.176:10148 issued: logview lines=100 reverse=0 instance=0 begin_pos=0",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919409,
	 *        "level":4,
	 *        "channel":"Query",
	 *        "server_id":"219",
	 *        "msg":"query from 60 92.63.203.176:10148 issued: serverinfo",
	 *        "msg_plain":"2017-07-24 21:03:29.069237|INFO    |Query         |219|query from 60 92.63.203.176:10148 issued: serverinfo",
	 *        "malformed":false
	 *      },
	 *      {
	 *        "timestamp":1500919432,
	 *        "level":4,
	 *        "channel":"Query",
	 *        "server_id":"219",
	 *        "msg":"query from 455 92.63.203.28:52266 issued: logview lines=100 begin_pos=1180941 instance=0",
	 *        "msg_plain":"2017-07-24 21:03:52.605526|INFO    |Query         |219|query from 455 92.63.203.28:52266 issued: logview lines=100 begin_pos=1180941 instance=0",
	 *        "malformed":false
	 *      }
	 *    ]
	 *  }
	 *}
	 */
	/**
	 * @param int $server_id
	 * @param string $bashe64uid
	 * @param int $last_pos
	 *
	 * @return JsonResponse
	 */
	function GetLog( int $server_id, string $bashe64uid, int $last_pos ): JsonResponse {
		$this->uid = base64_decode( $bashe64uid );

		$this->ts3conn = new TeamSpeak( $server_id, $this->uid );

		$data = $this->ts3conn->GetVirtualServerLog( $last_pos );

		return $this->jsonResponse( $data );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/serverinfo Информация о сервере
	 * @apiName TeamSpeak 3 server info
	 * @apiGroup Virtual Server
	 * @apiVersion 1.0.0
	 * @apiDescription Возврашает информацию о виртуальном teamspeak 3 сервере
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
	 * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/serverinfo
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.virtualserver.serverinfo
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *  "status":"success",
	 *  "data":{
	 *    "virtualserver_unique_identifier":"zJIp2R8zXbTeU7r2Okeqnsgxskw=",
	 *    "virtualserver_name":"TeamSpeak ]I[ Server",
	 *    "virtualserver_welcomemessage":"Welcome to TeamSpeak, check [URL]www.teamspeak.com[\/URL] for latest information",
	 *    "virtualserver_platform":"Linux",
	 *    "virtualserver_version":"3.0.13.6 [Build: 1478594913]",
	 *    "virtualserver_maxclients":"32",
	 *    "virtualserver_password":"",
	 *    "virtualserver_clientsonline":"2",
	 *    "virtualserver_channelsonline":"1",
	 *    "virtualserver_created":"1500930198",
	 *    "virtualserver_uptime":"1808",
	 *    "virtualserver_codec_encryption_mode":"0",
	 *    "virtualserver_hostmessage":"",
	 *    "virtualserver_hostmessage_mode":"0",
	 *    "virtualserver_filebase":"files\/virtualserver_219",
	 *    "virtualserver_default_server_group":"801",
	 *    "virtualserver_default_channel_group":"1554",
	 *    "virtualserver_flag_password":"0",
	 *    "virtualserver_default_channel_admin_group":"1551",
	 *    "virtualserver_max_download_total_bandwidth":"-1",
	 *    "virtualserver_max_upload_total_bandwidth":"-1",
	 *    "virtualserver_hostbanner_url":"",
	 *    "virtualserver_hostbanner_gfx_url":"",
	 *    "virtualserver_hostbanner_gfx_interval":"0",
	 *    "virtualserver_complain_autoban_count":"5",
	 *    "virtualserver_complain_autoban_time":"1200",
	 *    "virtualserver_complain_remove_time":"3600",
	 *    "virtualserver_min_clients_in_channel_before_forced_silence":"100",
	 *    "virtualserver_priority_speaker_dimm_modificator":"-18.0000",
	 *    "virtualserver_id":"219",
	 *    "virtualserver_antiflood_points_tick_reduce":"5",
	 *    "virtualserver_antiflood_points_needed_command_block":"150",
	 *    "virtualserver_antiflood_points_needed_ip_block":"250",
	 *    "virtualserver_client_connections":"0",
	 *    "virtualserver_query_client_connections":"56",
	 *    "virtualserver_hostbutton_tooltip":"",
	 *    "virtualserver_hostbutton_url":"",
	 *    "virtualserver_hostbutton_gfx_url":"",
	 *    "virtualserver_queryclientsonline":"2",
	 *    "virtualserver_download_quota":"-1",
	 *    "virtualserver_upload_quota":"-1",
	 *    "virtualserver_month_bytes_downloaded":"0",
	 *    "virtualserver_month_bytes_uploaded":"0",
	 *    "virtualserver_total_bytes_downloaded":"0",
	 *    "virtualserver_total_bytes_uploaded":"0",
	 *    "virtualserver_port":"50002",
	 *    "virtualserver_autostart":"1",
	 *    "virtualserver_machine_id":"1",
	 *    "virtualserver_needed_identity_security_level":"8",
	 *    "virtualserver_log_client":"0",
	 *    "virtualserver_log_query":"0",
	 *    "virtualserver_log_channel":"0",
	 *    "virtualserver_log_permissions":"1",
	 *    "virtualserver_log_server":"0",
	 *    "virtualserver_log_filetransfer":"0",
	 *    "virtualserver_min_client_version":"1445512488",
	 *    "virtualserver_name_phonetic":"",
	 *    "virtualserver_icon_id":"0",
	 *    "virtualserver_reserved_slots":"0",
	 *    "virtualserver_total_packetloss_speech":"0.0000",
	 *    "virtualserver_total_packetloss_keepalive":"0.0000",
	 *    "virtualserver_total_packetloss_control":"0.0000",
	 *    "virtualserver_total_packetloss_total":"0.0000",
	 *    "virtualserver_total_ping":"0.0000",
	 *    "virtualserver_ip":"0.0.0.0",
	 *    "virtualserver_weblist_enabled":"1",
	 *    "virtualserver_ask_for_privilegekey":"1",
	 *    "virtualserver_hostbanner_mode":"0",
	 *    "virtualserver_channel_temp_delete_delay_default":"0",
	 *    "virtualserver_min_android_version":"1407159763",
	 *    "virtualserver_min_ios_version":"1407159763",
	 *    "virtualserver_status":"online",
	 *    "connection_filetransfer_bandwidth_sent":"0",
	 *    "connection_filetransfer_bandwidth_received":"0",
	 *    "connection_filetransfer_bytes_sent_total":"0",
	 *    "connection_filetransfer_bytes_received_total":"0",
	 *    "connection_packets_sent_speech":"0",
	 *    "connection_bytes_sent_speech":"0",
	 *    "connection_packets_received_speech":"0",
	 *    "connection_bytes_received_speech":"0",
	 *    "connection_packets_sent_keepalive":"0",
	 *    "connection_bytes_sent_keepalive":"0",
	 *    "connection_packets_received_keepalive":"0",
	 *    "connection_bytes_received_keepalive":"0",
	 *    "connection_packets_sent_control":"0",
	 *    "connection_bytes_sent_control":"0",
	 *    "connection_packets_received_control":"0",
	 *    "connection_bytes_received_control":"0",
	 *    "connection_packets_sent_total":"0",
	 *    "connection_bytes_sent_total":"0",
	 *    "connection_packets_received_total":"0",
	 *    "connection_bytes_received_total":"0",
	 *    "connection_bandwidth_sent_last_second_total":"0",
	 *    "connection_bandwidth_sent_last_minute_total":"0",
	 *    "connection_bandwidth_received_last_second_total":"0",
	 *    "connection_bandwidth_received_last_minute_total":"0"
	 *  }
	 */
	/**
	 * @param int $server_id
	 * @param string $bashe64uid
	 *
	 * @return JsonResponse
	 */
	function ServerInfo( int $server_id, string $bashe64uid ): JsonResponse {
		$this->uid = base64_decode( $bashe64uid );

		$this->ts3conn = new TeamSpeak( $server_id, $this->uid );

		$data = $this->ts3conn->VirtualServerInfo();

		return $this->jsonResponse( $data );

	}

}