<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 02.07.2017
 * Time: 15:27
 */

namespace Api\Traits;


trait RestSuccessResponseTrait
{
    /**
     * @param null $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse( $data = null, $statusCode = 200)
    {
        $payload = ['status' => 'success'];
        $data = $data ? $payload['data'] = $data : [];

        return response()->json($payload, $statusCode);
    }
}