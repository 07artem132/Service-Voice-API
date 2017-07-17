<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.06.2017
 * Time: 15:28
 */

namespace Api\Http\Controllers\Api\TeamSpeak;

use Api\Services\TeamSpeak3\ts3query;
use Api\Http\Controllers\Controller;
use Api\Traits\RestHelperTrait;
use Api\Traits\RestSuccessResponseTrait;
use Request;

class InstanceQuery extends Controller
{
    use RestHelperTrait, RestSuccessResponseTrait;

    function hostinfo($server_id)
    {
        $ts3conn = new ts3query($server_id);
        $data = $ts3conn->hostinfo();

        return $this->jsonResponse($data);
    }

    function instanceinfo($server_id)
    {
        $ts3conn = new ts3query($server_id);
        $data = $ts3conn->instanceinfo();

        return $this->jsonResponse($data);
    }

    function GetInstanceLog($server_id, $last_pos)
    {
        $ts3conn = new ts3query($server_id);
        $data = $ts3conn->GetInstanseLog($last_pos);

        return $this->jsonResponse($data);
    }

    function GetVirtualServerLog($server_id, $bashe64uid, $last_pos)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);

        $data = $ts3conn->GetVirtualServerLog($last_pos);

        return $this->jsonResponse($data);

    }

    function VirtualServerStop($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);
        $ts3conn->VirtualServerStop();
        return $this->jsonResponse(null);
    }

    function VirtualServerBanList($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);
        $data = $ts3conn->VirtualServerBanList();
        return $this->jsonResponse($data);
    }

    //{"rules":{"name":"*"},"timeseconds":111111,"reason":123}
    function VirtualServerBanCreate($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);
        $json = $this->JsonDecodeAndValidate(Request::getContent(), true);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);
        $ts3conn->VirtualServerBanCreate($json);
        return $this->jsonResponse(null);

    }

    function VirtualServerBanDelete($server_id, $bashe64uid, $banid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);
        $ts3conn->VirtualServerBanDelete($banid);
        return $this->jsonResponse(null);
    }

    function VirtualServerBanListClear($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);
        $ts3conn->VirtualServerBanListClear();
        return $this->jsonResponse(null);
    }

    function VirtualServerInfo($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);
        $data = $ts3conn->serverinfo();
        return $this->jsonResponse($data);

    }

    function VirtualServerStart($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);
        $ts3conn->VirtualServerStart();
        return $this->jsonResponse(null);

    }

    function version($server_id)
    {
        $ts3conn = new ts3query($server_id);
        $data = $ts3conn->version();

        return $this->jsonResponse($data);
    }

    function VirtualServerCreate($server_id)
    {
        $json = $this->JsonDecodeAndValidate(Request::getContent(), true);

        $ts3conn = new ts3query($server_id);

        $data = $ts3conn->serverCreate($json);

        return $this->jsonResponse($data);
    }

    function serverlist($server_id)
    {
        $ts3conn = new ts3query($server_id);
        $data = $ts3conn->serverlist();

        return $this->jsonResponse($data);
    }

}