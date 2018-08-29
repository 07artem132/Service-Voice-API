<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 01.07.2017
 * Time: 0:34
 */

namespace Api\Http\Controllers;

use Api\TeamspeakInstances;
use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\Update;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;
use Api\Services\TeamSpeak3\BlacklistCheck;

class TeamSpeakHelpersController extends Controller
{
    use RestSuccessResponseTrait;

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/blacklisted Проверка инстанса на блек/грей лист
     * @apiName Instance Is Blacklisted
     * @apiGroup Helpers
     * @apiVersion 1.0.0
     * @apiDescription Возврашает код статуса и сообщение.<br/>
     * Возможные варианты:<br/>
     * code - 0 Сервер находиться в blacklist списке. (Нельзя подключиться)<br/>
     * code - 1 Сервер не находится в blacklist или greylist списке.<br/>
     * code - 2 Сервер находиться в greylist списке. (Подключаться можно но будет высплываюшее окошко).<br/>
     * @apiSampleRequest /teamspeak/instance/:server_id/blacklisted
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.blacklisted
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "code":1,
     *    "message":"Сервер не находится в blacklist или greylist списке."
     *  }
     *}
     */
    /**
     * @param int $server_id Уникальный идентификатор сервера
     * @return JsonResponse Обьект с данными для ответа
     */
    function InstanceIsBlacklisted(int $server_id): JsonResponse
    {
        $ipAddress = TeamspeakInstances::find($server_id)->hostname;

        $BlacklistCheck = new BlacklistCheck();
        $data = $BlacklistCheck->isBlacklisted($ipAddress);

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/helpers/:ip/blacklisted Проверка ipv4 на блек/грей лист
     * @apiName ipv4 Is Blacklisted
     * @apiGroup Helpers
     * @apiVersion 1.0.0
     * @apiDescription Возврашает код статуса и сообщение.<br/>
     * Возможные варианты:<br/>
     * code - 0 Сервер находиться в blacklist списке. (Нельзя подключиться)<br/>
     * code - 1 Сервер не находится в blacklist или greylist списке.<br/>
     * code - 2 Сервер находиться в greylist списке. (Подключаться можно но будет высплываюшее окошко).<br/>
     * @apiSampleRequest /teamspeak/helpers/:ip/blacklisted
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.helpers.blacklisted
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "code":1,
     *    "message":"Сервер не находится в blacklist или greylist списке."
     *  }
     *}
     */
    /**
     * @param string $ip IP адрес проверяемого хоста
     * @return JsonResponse Обьект с данными для ответа
     */
    function IPv4IsBlacklisted(string $ip): JsonResponse
    {
        $BlacklistCheck = new BlacklistCheck();
        $data = $BlacklistCheck->isBlacklisted($ip);

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/helpers/server/update/mirror/list Зеркала для обновления сервера
     * @apiName Update Server Mirror List
     * @apiGroup Helpers
     * @apiVersion 1.0.0
     * @apiDescription Возврашает набор ссылок для скачивания того или инного варианта teamspeak3 сервера с сервера обновлений(может быть приватный репозиторий).<br/>
     * @apiSampleRequest /teamspeak/helpers/server/update/mirror/list
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.helpers.UpdateMirrorList
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "windows":{
     *      "x86":{
     *        "version":"3.0.13.6",
     *        "checksum":"f5acf2960685992258a6701ce0cd98aa223bab009321527042e54fd1543b7776",
     *        "mirrors":{
     *          "4Netplayers.de":"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_win32-3.0.13.6.zip",
     *          "gamed!de":"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_win32-3.0.13.6.zip"
     *        }
     *      },
     *      "x86_64":{
     *        "version":"3.0.13.6",
     *        "checksum":"c7eeb1937b0bce0b99e7c7e20de030a4b71adcaf09750481801cfa361433522f",
     *        "mirrors":{
     *          "4Netplayers.de":"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_win64-3.0.13.6.zip",
     *          "gamed!de":"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_win64-3.0.13.6.zip"
     *        }
     *      }
     *    },
     *    "macos":{
     *      "x86_64":{
     *        "version":"3.0.13.6",
     *        "checksum":"cca43b0a4275f6d4270abb2285e76021bc7ebb295be7ec8f2cbdabf4e9b91763",
     *        "mirrors":{
     *          "4Netplayers.de":"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_mac-3.0.13.6.zip",
     *          "gamed!de":"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_mac-3.0.13.6.zip"
     *        }
     *      }
     *    },
     *    "linux":{
     *      "x86":{
     *        "version":"3.0.13.6",
     *        "checksum":"2f70b3e70a3d9bf86106fab67a938922c8d27fec24e66e229913f78a0791b967",
     *        "mirrors":{
     *          "4Netplayers.de":"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_linux_x86-3.0.13.6.tar.bz2",
     *          "gamed!de":"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_linux_x86-3.0.13.6.tar.bz2"
     *        }
     *      },
     *      "x86_64":{
     *        "version":"3.0.13.6",
     *        "checksum":"19ccd8db5427758d972a864b70d4a1263ebb9628fcc42c3de75ba87de105d179",
     *        "mirrors":{
     *          "4Netplayers.de":"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_linux_amd64-3.0.13.6.tar.bz2",
     *          "gamed!de":"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_linux_amd64-3.0.13.6.tar.bz2"
     *        }
     *      }
     *    },
     *    "freebsd":{
     *      "x86":{
     *        "version":"3.0.13.6",
     *        "checksum":"bea0631115395337f1064746ee69cb720c3dd8c176886288b750739193a07e0b",
     *        "mirrors":{
     *          "4Netplayers.de":"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_freebsd_x86-3.0.13.6.tar.bz2",
     *          "gamed!de":"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_freebsd_x86-3.0.13.6.tar.bz2"
     *        }
     *      },
     *      "x86_64":{
     *        "version":"3.0.13.6",
     *        "checksum":"11d24d7d2c1197fec924d2a9fb480f6912f27d489f4a76f4382c5d06735acb53",
     *        "mirrors":{
     *          "4Netplayers.de":"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_freebsd_amd64-3.0.13.6.tar.bz2",
     *          "gamed!de":"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_freebsd_amd64-3.0.13.6.tar.bz2"
     *        }
     *      }
     *    }
     *  }
     *}
     */
    /**
     * @return JsonResponse Обьект с данными для ответа
     */
    function UpdateServerMirrorList(): JsonResponse
    {
        $Updater = new Update;
        $data = $Updater->GetUpdateServerMirrorList();

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/outdated Актуальность инстанса(версия)
     * @apiName Instance Outdated Check
     * @apiGroup Helpers
     * @apiVersion 1.0.0
     * @apiDescription Сверяет текушую версию и доступную из репозитория (который указан в конфигурации)
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/outdated
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.instance.outdated
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "outdated":false,
     *    "ServerVersion":"3.0.13.6",
     *    "VersionUpdateServer":"3.0.13.6"
     *  }
     *}
     */
    /**
     * @param int $server_id Уникальный идентификатор сервера
     * @return JsonResponse Обьект с данными для ответа
     */
    function InstanceOutdatedCheck(int $server_id): JsonResponse
    {
        $ts3conn = new TeamSpeak($server_id);;
        $OutdatedChecker = new Update;

        $version = (string)$ts3conn->version()['version'];
        $os = (string)$ts3conn->version()['platform'];

        $data = $OutdatedChecker->OutdatedCheck($version, $os);

        return $this->jsonResponse($data);
    }

}