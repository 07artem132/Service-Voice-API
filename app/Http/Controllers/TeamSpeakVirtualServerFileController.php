<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 02.08.2017
 * Time: 16:34
 */

namespace Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;
use Storage;

class TeamSpeakVirtualServerFileController extends Controller
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

    private $FileSrc;
    private $cid;

    /**
     * @api {get} /v1/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/file Список файлов
     * @apiName TeamSpeak 3 file list
     * @apiGroup Virtual Server File
     * @apiVersion 1.0.0
     * @apiDescription Возврашает список файлов загруженных на виртуальный TeamSpeak 3 сервер
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/file
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.file.list
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "1939":null,
     *    "1935":null,
     *    "1934":null,
     *    "1940":[
     *      {
     *        "cid":1940,
     *        "path":"\/",
     *        "name":"yatqa.ini",
     *        "size":50072,
     *        "datetime":1503919503,
     *        "type":1,
     *        "sid":219,
     *        "src":"\/yatqa.ini"
     *      },
     *      {
     *        "cid":1940,
     *        "path":"\/13",
     *        "name":"yatqa.ini",
     *        "size":50072,
     *        "datetime":1503919558,
     *        "type":1,
     *        "sid":219,
     *        "src":"\/13\/yatqa.ini"
     *      }
     *    ]
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

        $ts3conn = new TeamSpeak($this->instance_id, $this->uid);
        $ChannelList = $ts3conn->VirtualServerChannelList();

        foreach ($ChannelList as $ChannelID => $ChannelInfo) {
            $data[$ChannelID] = $ts3conn->VirtualServerChannelFileList($ChannelID);
        }

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/file/:cid/:bashe64src Скачать файл
     * @apiName TeamSpeak 3 file download
     * @apiGroup Virtual Server File
     * @apiVersion 1.0.0
     * @apiDescription Возврашает ссылку по которой можно скачать файл (Так же данную ссылку можно использовать для встраивания в сайт, но файл по ссылке удалится через Х дней).
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} cid Уникальный идентификатор канала для данного виртуального сервера.
     * @apiParam {Number} bashe64src Полный путь к файлу в рамках указанного канала закондированный в bashe64.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/file/:cid/:bashe64src
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.file.download
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "url": "http://api-dev.service-voice.com/storage/teamspeak3/file/yatqa.ini"
     *  }
     *}
     */
    /**
     * @param int $instance_id
     * @param string $bashe64uid
     * @param int $cid
     * @param string $bashe64src
     * @return JsonResponse
     */
    function Download(int $instance_id, string $bashe64uid, int $cid, string $bashe64src): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);
        $this->FileSrc = base64_decode($bashe64src);
        $this->cid = $cid;

        $storage = config('TeamSpeak.file.storage');
        $path = config('TeamSpeak.file.path');

        $ts3conn = new TeamSpeak($this->instance_id, $this->uid);
        $file = $ts3conn->DownloadFile($this->cid, $this->FileSrc);

        $path .= last(preg_split('/\//', $this->FileSrc));

        if (!Storage::disk($storage)->exists($path))
            Storage::disk($storage)->put($path, $file);

        $data['url'] = Storage::disk($storage)->url($path);

        return $this->jsonResponse($data);
    }

    /**
     * @api {delete} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/file/:cid/:bashe64src Удалить файл
     * @apiName TeamSpeak 3 file delete
     * @apiGroup Virtual Server File
     * @apiVersion 1.0.0
     * @apiDescription Удаляет файл с виртуального TeamSpeak 3 сервера
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} cid Уникальный идентификатор канала для данного виртуального сервера.
     * @apiParam {Number} bashe64src Полный путь к файлу в рамках указанного канала закондированный в bashe64.
     * @apiSampleRequest } /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/file/:cid/:bashe64src
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.file.delete
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
     * @param int $cid
     * @param string $bashe64src
     * @return JsonResponse
     */
    function Delete(int $instance_id, string $bashe64uid, int $cid, string $bashe64src): JsonResponse
    {
        $this->instance_id = $instance_id;
        $this->uid = base64_decode($bashe64uid);
        $this->FileSrc = base64_decode($bashe64src);
        $this->cid = $cid;

        $ts3conn = new TeamSpeak($this->instance_id, $this->uid);
        $ts3conn->DeleteFile($this->cid, $this->FileSrc);

        return $this->jsonResponse(null);
    }
}