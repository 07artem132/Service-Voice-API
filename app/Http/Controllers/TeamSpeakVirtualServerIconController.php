<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 16.07.2017
 * Time: 17:56
 */

namespace Api\Http\Controllers;

use Request;
use Storage;
use \Eventviva\ImageResize;
use Api\Traits\RestHelperTrait;
use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\TeamSpeak;
use Api\Traits\RestSuccessResponseTrait;

class TeamSpeakVirtualServerIconController extends Controller
{
    use RestHelperTrait, RestSuccessResponseTrait;

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon Список иконок
     * @apiName TeamSpeak 3 icon list
     * @apiGroup Virtual Server icon
     * @apiVersion 1.0.0
     * @apiDescription Возврашает список иконок загруженных на виртуальный TeamSpeak 3 сервер
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.icon.list
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "1":{
     *      "name":"icon_1033199317",
     *      "size":3328,
     *      "datetime":1500995541,
     *      "type":1,
     *      "sid":219,
     *      "cid":0,
     *      "path":"\/icons",
     *      "src":"\/icon_1033199317"
     *    },
     *    "2":{
     *      "name":"icon_3797757982",
     *      "size":3252,
     *      "datetime":1500995542,
     *      "type":1,
     *      "sid":219,
     *      "cid":0,
     *      "path":"\/icons",
     *      "src":"\/icon_3797757982"
     *    },
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

        $data = $ts3conn->GetVirtualServerIconList();

        if ($ts3conn->GetVirtualServerIconList() === null)
            $data = 'empty';

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon/:icon_id Скачать иконку
     * @apiName TeamSpeak 3 icon download
     * @apiGroup Virtual Server icon
     * @apiVersion 1.0.0
     * @apiDescription Возврашает ссылку по которой можно скачать иконку (Так же данную ссылку можно использовать для встраивания в сайт).
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} icon_id crc32 хен иконки которую необходимо скачать.
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon/:icon_id
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.icon.download
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "url": "http://api-dev.service-voice.com/storage/teamspeak3/icon/4058875043.png"
     *  }
     *}
     */
    /**
     * @param int $server_id
     * @param string $bashe64uid
     * @param int $icon_id
     * @return JsonResponse
     */
    function Download(int $server_id, string $bashe64uid, int $icon_id): JsonResponse
    {
        $uid = base64_decode($bashe64uid);
        $name = '/icon_' . $icon_id;
        $path = config('TeamSpeak.icon.path') . $icon_id . '.png';
        $storage = config('TeamSpeak.icon.storage');

        $ts3conn = new TeamSpeak($server_id, $uid);

        $image = $ts3conn->DownloadFile(0, $name, '');

        if (!Storage::disk($storage)->exists($path))
            Storage::disk($storage)->put($path, $image);

        $data['url'] = Storage::disk($storage)->url($path);

        return $this->jsonResponse($data);
    }

    /**
     * @api {post} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon Загрузить иконку
     * @apiName TeamSpeak 3 icon upload
     * @apiGroup Virtual Server icon
     * @apiVersion 1.0.0
     * @apiDescription Загружает иконку на сервер и возврашает crc32 хеш ее. <br/><br/>
     * В теле запроса необходимо передать иконку. В случае если конка больше чем 16*16 она будет уменьшена
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiSampleRequest /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.icon.upload
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":{
     *    "icon_id": 775121391
     *  }
     *}
     */
    /**
     * @param int $server_id
     * @param string $bashe64uid
     * @return JsonResponse
     */
    function Upload(int $server_id, string $bashe64uid): JsonResponse
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new TeamSpeak($server_id, $uid);

        $img = Request::getContent();

        $img = ImageResize::createFromString($img);
        $img->resizeToShortSide(16, true);

        $img = $img->getImageAsString(IMAGETYPE_PNG);

        $data['icon_id'] = $ts3conn->iconUpload($img);

        return $this->jsonResponse($data);

    }

    /**
     * @api {delete} /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon/:icon_id Удалить иконку
     * @apiName TeamSpeak 3 icon delete
     * @apiGroup Virtual Server icon
     * @apiVersion 1.0.0
     * @apiDescription Удаляет иконку с виртуального TeamSpeak 3 сервера
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} icon_id crc32 хен иконки которую необходимо скачать.
     * @apiSampleRequest } /v1/teamspeak/instance/:server_id/virtualserver/:bashe64uid/icon/:icon_id
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.icon.delete
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
     * @param int $icon_id
     * @return JsonResponse
     */
    function Delete(int $server_id, string $bashe64uid, int $icon_id): JsonResponse
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new TeamSpeak($server_id, $uid);

        $ts3conn->DeleteFile(0, '/icon_' . $icon_id, '');

        return $this->jsonResponse(null);
    }
}