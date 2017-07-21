<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.06.2017
 * Time: 14:04
 */

namespace Api\Http\Controllers;

use Api\SnapshotsVirtualServers;
use Illuminate\Http\JsonResponse;
use Api\Services\TeamSpeak3\ts3query;
use Api\Traits\RestSuccessResponseTrait;


/**
 * Class SnapshotController
 * @package Api\Http\Controllers
 */
class SnapshotController extends Controller
{
    use RestSuccessResponseTrait;

    /**
     * @var int Уникальный идентификатор сервера
     */
    private $server_id;
    /**
     * @var string Уникальный идентификатор виртуального сервера
     */
    private $uid;


    /**
     * @api {post} /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot Создать snapshot
     * @apiName Create virtual server snapshot
     * @apiGroup Snapshots
     * @apiVersion 1.0.0
     * @apiDescription Создает снимок (Snapshot) виртуального сервера
     * и возврашает информацию о том была ли успешно выполнена операция
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.snapshot.create
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiUse INVALID_UID
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *    {
     * "status":"success",
     * "data":{
     *      "port": 50002,
     *      "snapshot":"hash=kjzIWH0YVgrFEe0sbtxVFHdItGU=|virtualserver_unique_identifier=zNyux21EbZojh3NTqAPXDSvKuYE=.....",
     *      "created_at":"2017-07-05 17:48:16"
     *    }
     * }
     */
    /**
     * @param int $server_id Уникальный идентификатор сервера
     * @param string $bashe64uid Уникальный идентификатор виртуального сервера
     * @return JsonResponse Обьект с данными для ответа
     */
    function Create(int $server_id, string $bashe64uid): JsonResponse
    {
        $this->uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($this->uid);
        $snapshot = $ts3conn->snapshotCreate();
        $serverinfo = $ts3conn->serverinfo()[0];
        $ts3conn->logout();

        $db = new SnapshotsVirtualServers;
        $db->server_id = $server_id;
        $db->port = $serverinfo['virtualserver_port'];
        $db->unique_id = $this->uid;
        $db->snapshot = $snapshot;
        $db->saveOrFail();

        $data['port'] = $serverinfo['virtualserver_port'];
        $data['snapshot'] = $snapshot;
        $data['created_at'] = date("Y-m-d H:i:s");

        return $this->jsonResponse($data);
    }

    /**
     * @api {get} /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id  Получить snapshot
     * @apiName Get snapshot virtual server from id
     * @apiGroup Snapshots
     * @apiVersion 1.0.0
     * @apiDescription Возврашает снимок (Snapshot) виртуального сервера
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiParam {Number} snapshot_id Уникальный ID снимка (snapshot) виртуального TeamSpeak3 сервера.
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiSuccess (Success code 200) {Object}  data  Содержит информацию полученную из базы данных.
     * @apiSuccess (Поля обьекта data) {String} snapshot  Сам снапшот.
     * @apiSuccess (Поля обьекта data) {String} created_at  Дата и время создания снапшота.
     * @apiPermission api.teamspeak.virtualserver.snapshot.get
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *    {
     * "status":"success",
     * "data":{
     *      "port": 50002,
     *      "snapshot":"hash=kjzIWH0YVgrFEe0sbtxVFHdItGU=|virtualserver_unique_identifier=zNyux21EbZojh3NTqAPXDSvKuYE=.....",
     *      "created_at":"2017-07-05 17:48:16"
     *    }
     * }
     */
    /**
     * @param integer $snapshot_id Уникальный идентификатор снапшота
     * @param int $server_id Уникальный идентификатор сервера
     * @param string $bashe64uid Уникальный идентификатор виртуального сервера
     * @return JsonResponse Обьект с данными для ответа
     */
    function Get(int $server_id, string $bashe64uid, int $snapshot_id): JsonResponse
    {
        $this->uid = base64_decode($bashe64uid);
        $this->server_id = $server_id;

        $SnapshotsVirtualServers = SnapshotsVirtualServers::UserSnapshot($this->server_id, $this->uid, $snapshot_id)->first();
        //TODO если пользователь обращается НЕ к своему снапшоту нужно бросить исключение

        if (empty($SnapshotsVirtualServers))
            return $this->jsonResponse('empty');

        return $this->jsonResponse($SnapshotsVirtualServers);
    }

    /**
     * @api {get} /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/ Список всех snapshot
     * @apiName Get list all snapshot virtual server
     * @apiGroup Snapshots
     * @apiVersion 1.0.0
     * @apiDescription Возврашает список снимоков (Snapshot) виртуального сервера
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiSuccess (Success code 200) {Object}  data  Содержит информацию полученную из базы данных.
     * @apiSuccess (Поля обьекта data) {String} id  Уникальный идентификатор снимка (Snapshot) виртуального сервера.
     * @apiSuccess (Поля обьекта data) {String} created_at  Дата и время создания снапшота.
     * @apiPermission api.teamspeak.virtualserver.snapshot.list
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
     *    "status": "success",
     *    "data": [
     *        {
     *            "id": 1,
     *            "created_at": "2017-07-05 17:48:16"
     *        },
     *        {
     *            "id": 2,
     *            "created_at": "2017-07-05 19:37:32"
     *        },
     *        {
     *            "id": 3,
     *            "created_at": "2017-07-05 19:38:07"
     *        }
     *    ]
     *}
     */
    /**
     * @param int $server_id Уникальный идентификатор сервера
     * @param string $bashe64uid Уникальный идентификатор виртуального сервера
     * @return JsonResponse Обьект с данными для ответа
     */
    function GetList(int $server_id, string $bashe64uid): JsonResponse
    {
        $data = [];

        $this->uid = base64_decode($bashe64uid);
        $this->server_id = $server_id;

        $SnapshotsVirtualServers = SnapshotsVirtualServers::SnapshotList($this->uid, $this->server_id)->get();

        if ($SnapshotsVirtualServers->count() === 0)
            return $this->jsonResponse('empty');

        foreach ($SnapshotsVirtualServers as $SnapshotsVirtualServer) {
            $data[] = [
                'id' => $SnapshotsVirtualServer->id,
                'created_at' => (string)$SnapshotsVirtualServer->created_at
            ];
        }

        return $this->jsonResponse($data);
    }

    /**
     * @api {delete} /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id Удалить snapshot
     * @apiName Delete virtual server snapshot
     * @apiGroup Snapshots
     * @apiVersion 1.0.0
     * @apiDescription Удаляет снимок (Snapshot) виртуального сервера
     * и возврашает информацию о том была ли успешно выполнена операция
     * @apiSampleRequest /api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id
     * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
     * @apiParam {String} bashe64uid Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.teamspeak.virtualserver.snapshot.delete
     * @apiUse INVALID_SERVER_ID
     * @apiUse SOURCE_NOT_AVAILABLE
     * @apiUse FIELD_NOT_SPECIFIED
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse TOKEN_IS_BLOCKED
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": "success",
     *        "data": {
     *             "Удалено элементов": 1
     *            }
     *     }
     */
    /**
     * @param integer $snapshot_id Уникальный идентификатор снапшота
     * @param int $server_id Уникальный идентификатор сервера
     * @param string $bashe64uid Уникальный идентификатор виртуального сервера
     * @return JsonResponse Обьект с данными для ответа
     */
    function Delete(int $server_id, string $bashe64uid, int $snapshot_id): JsonResponse
    {
        $this->uid = base64_decode($bashe64uid);
        $this->server_id = $server_id;

        $DeleteRow = SnapshotsVirtualServers::SnapshotList($this->uid, $this->server_id)->Snapshot($snapshot_id)->delete();
        //TODO если пользователь хочет удалить НЕ свойснапшот нужно бросить исключение

        return $this->jsonResponse(['Удалено элементов' => $DeleteRow]);
    }
}