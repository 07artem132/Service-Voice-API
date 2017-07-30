<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.07.2017
 * Time: 18:05
 */

namespace Api\Http\Middleware;

use Api\UserToken;
use Closure;

class TokenVerifiTeamSpeakServerAllow
{
    public function handle($request, Closure $next)
    {

        $server_id = (int)$request->server_id;
        $token = $request->header('X-token');

        $result = UserToken::with('servers', 'TeamspeakVirtualServers')->where('token', '=', $token)->first();

        $AllowServers = $result->servers->toArray();


        if ($this->VerifiAllowServers($server_id, $AllowServers))
            return $next($request);

        throw new TeamspeakServersNotAllowExceptions($server_id);
    }

    function VerifiAllowServers(int $server_id, ?array $AllowServers): bool
    {
        if (empty($AllowServers))
            return false;

        for ($i = 0; $i < count($AllowServers); $i++)
            if ($server_id === $AllowServers[$i]['instance_id'])
                return true;

        return false;
    }

}