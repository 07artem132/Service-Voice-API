<?php

/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.06.2017
 * Time: 18:37
 */

namespace Api\Traits;

use Api\Exceptions\InvalidToken;
use Api\Exceptions\IPNotAllow;
use Api\Exceptions\TeamSpeakInvalidUidException;
use Api\Exceptions\TokenBlocked;
use Api\Exceptions\NotSpecified;
use Api\Exceptions\TooManyRequest;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Api\Exceptions\InstanceConfigNotFoundException;
use Api\Exceptions\InvalidJSON;

trait RestExceptionHandlerTrait
{

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        switch (true) {
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound($e->getMessage());
                break;
            case $this->isNotFoundHttpException($e);
                $retval = $this->NotFound();
                break;
            case $this->isInvalidJSONException($e);
                $retval = $this->BadJson($e->getMessage());
                break;
            case $this->isMethodNotAllowedHttpException($e);
                $retval = $this->ErrorMethodRequert('Используется не верный метод запроса разрешен(ы) только: ' . $e->getHeaders()['Allow'], 405, $e->getHeaders());
                break;
            case $this->isInstanceConfigNotFoundException($e);
                $retval = $this->InstanceConfigNotFoundException($e->Instanse_ID);
                break;
            case $this->isIPNotAllow($e); //OK
                $retval = $this->InvalidIpAddress($request->ip());
                break;
            case $this->isInvalidToken($e);
                $retval = $this->InvalidToken($request->header('X-token'));
                break;
            case $this->isNotSpecified($e);
                $retval = $this->NotSpecified($e->field);
                break;
            case $this->isTokenBlocked($e);
                $retval = $this->TokenBlocked();
                break;
            case $this->isTooManyRequest($e);
                $retval = $this->TooManyRequest($e->retryAfter);
                break;
            case $this->isQueryException($e);
                $retval = $this->SourceNotAvailable();
                break;
            case $this->isTeamSpeakInvalidUidException($e);
                $retval = $this->TeamSpeakInvalidUid();
                break;
            default:
                $retval = $this->badRequest($e->getMessage());
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message = 'Неизвестная ошибка', $statusCode = 400)
    {
        return $this->jsonResponse(['status' => 'unsuccess', 'error' => $message], $statusCode);
    }
    /**
     * @apiDefine INVALID_UID
     *
     * @apiError (Error code 400) INVALID_UID Виртуального сервера с таким UID не сушествует.
     *
     * @apiErrorExample {json} Не верный UID:
     *     HTTP/1.1 400 Bad Request
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 400,
     *        "message": "INVALID_UID",
     *    }
     *}
     */

    protected function TeamSpeakInvalidUid($message = 'Сервера с таким UID не сушествует', $statusCode = 400)
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => $statusCode,
                'message' => 'INVALID_UID',
            ]
        ], $statusCode, null);

    }

    protected function BadJson($message = 'Ошибка при парсинге JSON', $statusCode = 500)
    {
        return $this->jsonResponse(['status' => 'unsuccess', 'error' => $message], $statusCode);
    }

    protected function NotFound($error = 'NotFound', $message = 'Такого вызова API не существует', $statusCode = 404)
    {
        return $this->jsonResponse(['status' => 'unsuccess', 'error' => $error, 'message' => $message], $statusCode);

    }

    protected function ErrorMethodRequert($message, $statusCode = 405, $Header)
    {
        return $this->jsonResponse(['status' => 'unsuccess', 'error' => $message], $statusCode, $Header);
    }

    /**
     * @apiDefine SOURCE_NOT_AVAILABLE
     *
     * @apiError (Error code 504) SOURCE_NOT_AVAILABLE Источник данных не доступен.
     *
     * @apiErrorExample {json} Источник данных не доступен:
     *     HTTP/1.1 504 Gateway Timeout
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 504,
     *        "message": "SOURCE_NOT_AVAILABLE",
     *    }
     *}
     */
    protected function SourceNotAvailable()
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => 504,
                'message' => 'SOURCE_NOT_AVAILABLE',
            ]
        ], 504, null);
    }

    /**
     * @apiDefine FIELD_NOT_SPECIFIED
     *
     * @apiError (Error code 400) FIELD_NOT_SPECIFIED Не заполнено обязательное поле %FIELD% (будет заменено на название поля).
     *
     * @apiErrorExample {json} Не заполнено обязательное поле:
     *     HTTP/1.1 400 Bad Request
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 400,
     *        "message": "X-TOKEN_NOT_SPECIFIED",
     *    }
     *}
     */
    protected function NotSpecified($field)
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => 400,
                'message' => mb_strtoupper($field) . '_NOT_SPECIFIED',
            ]
        ], 400, null);
    }

    /**
     * @apiDefine INVALID_SERVER_ID
     *
     * @apiError (Error code 404) INVALID_SERVER_ID Не верный ID сервера (сервера с таким ID не сушествует).
     *
     * @apiErrorExample {json} Не верный ID сервера:
     *     HTTP/1.1 404 Not Found
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 404,
     *        "message": "INVALID_SERVER_ID",
     *        "instanse_id": "10"
     *    }
     *}
     */
    /**
     * @param int $Instanse_ID
     * @return \Illuminate\Http\JsonResponse
     */
    protected function InstanceConfigNotFoundException(integer $Instanse_ID)
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => 404,
                'message' => 'INVALID_SERVER_ID',
                'instanse_id' => $Instanse_ID
            ]
        ], 404, null);
    }

    /**
     * @apiDefine INVALID_IP_ADDRESS
     *
     * @apiError (Error code 403) INVALID_IP_ADDRESS Недопустимый IP-адрес для серверного приложения.
     *
     * @apiErrorExample {json} Недопустимый IP-адрес для серверного приложения:
     *     HTTP/1.1 403 Forbidden
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 403,
     *        "message": "INVALID_IP_ADDRESS",
     *        "Your_IP_Address": "127.0.2.5"
     *    }
     *}
     */
    /**
     * @param $ip string
     * @return \Illuminate\Http\JsonResponse
     */
    protected function InvalidIpAddress(string $ip)
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => 403,
                'message' => 'INVALID_IP_ADDRESS',
                'Your_IP_Address' => $ip
            ]
        ], 403, null);
    }

    /**
     * @apiDefine REQUEST_LIMIT_EXCEEDED
     *
     * @apiError (Error code 429) REQUEST_LIMIT_EXCEEDED Превышен лимит запросов для переданного токена.
     *
     * @apiErrorExample {json} Превышен лимит запросов:
     *     HTTP/1.1 429 Too Many Requests
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 429,
     *        "message": "REQUEST_LIMIT_EXCEEDED",
     *        "retry_after_through": 14
     *    }
     *}
     */
    /**
     * @param int $retryAfter
     * @return \Illuminate\Http\JsonResponse
     */
    protected function TooManyRequest(int $retryAfter)
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => 429,
                'message' => 'REQUEST_LIMIT_EXCEEDED',
                'retry_after_through' => $retryAfter,
            ]
        ], 429, ['Retry-After' => $retryAfter]);
    }

    /**
     * @apiDefine INVALID_TOKEN
     *
     * @apiError (Error code 403) INVALID_TOKEN Не верный токен.
     *
     * @apiErrorExample {json} Не верный токен:
     *     HTTP/1.1 403 Forbidden
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 403,
     *        "message": "INVALID_TOKEN",
     *        "X-token": "zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd"
     *    }
     *}
     */
    /**
     * @param $token string
     * @return \Illuminate\Http\JsonResponse
     */
    protected function InvalidToken(string $token)
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => 403,
                'message' => 'INVALID_TOKEN',
                'X-token' => $token
            ]
        ], 403, null);
    }

    /**
     * @apiDefine TOKEN_IS_BLOCKED
     *
     * @apiError (Error code 403) TOKEN_IS_BLOCKED Приложение заблокировано администрацией.
     *
     * @apiErrorExample {json} Приложение заблокировано администрацией:
     *     HTTP/1.1 403 Forbidden
     *{
     *    "status": "error",
     *    "error": {
     *        "code": 403,
     *        "message": "TOKEN_IS_BLOCKED",
     *    }
     *}
     */
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function TokenBlocked()
    {
        return $this->jsonResponse([
            'status' => 'error',
            'error' => [
                'code' => 403,
                'message' => 'TOKEN_IS_BLOCKED',
            ]
        ], 403, null);
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message = 'Данные не найдены', $statusCode = 404)
    {
        return $this->jsonResponse(['status' => 'unsuccess', 'error' => $message], $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload = null, int $statusCode = 404, array $headers = null)
    {
        $payload = $payload ?: [];
        if ($headers === null)
            return response()->json($payload, $statusCode);

        return response()->json($payload, $statusCode)->withHeaders($headers);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isInvalidJSONException(Exception $e)
    {
        return $e instanceof InvalidJSON;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isMethodNotAllowedHttpException(Exception $e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isInstanceConfigNotFoundException(Exception $e)
    {
        return $e instanceof InstanceConfigNotFoundException;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isNotFoundHttpException(Exception $e)
    {
        return $e instanceof NotFoundHttpException;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isIPNotAllow(Exception $e)
    {
        return $e instanceof IPNotAllow;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isInvalidToken(Exception $e)
    {
        return $e instanceof InvalidToken;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isTokenBlocked(Exception $e)
    {
        return $e instanceof TokenBlocked;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isTooManyRequest(Exception $e)
    {
        return $e instanceof TooManyRequest;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    protected function isNotSpecified(Exception $e)
    {
        return $e instanceof NotSpecified;
    }

    protected function isQueryException(Exception $e)
    {
        return $e instanceof QueryException;
    }

    protected function isTeamSpeakInvalidUidException(Exception $e)
    {
        return $e instanceof TeamSpeakInvalidUidException;
    }
}
