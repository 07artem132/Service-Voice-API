<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 16.07.2017
 * Time: 17:56
 */

namespace Api\Http\Controllers\Api\TeamSpeak;

use Api\Traits\RestHelperTrait;
use Api\Traits\RestSuccessResponseTrait;
use Api\Services\TeamSpeak3\ts3query;
use Api\Http\Controllers\Controller;
use Request;
use \Eventviva\ImageResize;

class IconController extends Controller
{
    use RestHelperTrait, RestSuccessResponseTrait;

    function List($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);

        $data = $ts3conn->GetVirtualServerIconList();

        return $this->jsonResponse($data);
    }

    function Upload($server_id, $bashe64uid)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);

        $img = Request::getContent();

        list($width, $height) = getimagesizefromstring($img);

        if ($width > 16 && $height > 16) {
            $img = ImageResize::createFromString($img);
            $img->resize(16, 16);
            $img = $img->getImageAsString(IMAGETYPE_PNG);
        }

        $data['icon_id'] = $ts3conn->iconUpload($img);

        return $this->jsonResponse($data);

    }

    function Delete($server_id, $bashe64uid, $icon_id)
    {
        $uid = base64_decode($bashe64uid);

        $ts3conn = new ts3query($server_id);
        $ts3conn->serverGetByUid($uid);

        $ts3conn->DeleteFile('/icon_' . $icon_id);

        return $this->jsonResponse(null);
    }
}