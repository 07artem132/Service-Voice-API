<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.06.2017
 * Time: 18:38
 */

namespace Api\Traits;


use Illuminate\Http\Request;

trait RestTrait
{

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), 'api.service-voice.com') !== false;
    }

}
