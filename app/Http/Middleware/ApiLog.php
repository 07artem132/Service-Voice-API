<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 07.07.2017
 * Time: 19:32
 */

namespace Api\Http\Middleware;

use Illuminate\Contracts\Routing\TerminableMiddleware;
use Closure;
use Api\ApiLog as DbLog;

class ApiLog
{
    public function handle($request, Closure $next)
    {
        $request->StartTime = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $log = new DbLog;
        $log->token = $request->header('X-token');
        $log->method = $request->path();
        $log->execute_time = microtime(true) - $request->StartTime;
        $log->client_ip = $request->ip();
        $log->save();

    }

}
