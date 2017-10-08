<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.07.2017
 * Time: 12:07
 */

namespace Api\Http\Middleware;

use Api\UserToken;
use Closure;
use Api\Exceptions\TeamspeakVirtualServersNotAllowExceptions;

class TokenVerifiTeamSpeakVitrualServerAllow
{

    public function handle($request, Closure $next)
    {

        $server_id = (int)$request->server_id;
        $uid = base64_decode($request->bashe64uid);
        $token = $request->header('X-token');

        $result = UserToken::with('servers', 'TeamspeakVirtualServers')->where('token', '=', $token)->first();

        $AllowServers = $result->servers->toArray();
        $AllowTeamspeakVirtualServers = $result->TeamspeakVirtualServers->toArray();


        if ($this->VerifiAllowServers($server_id, $AllowServers)
            || $this->VerifiAllowTeamspeakVirtualServers($server_id, $uid, $AllowTeamspeakVirtualServers))
            return $next($request);

        throw new TeamspeakVirtualServersNotAllowExceptions($server_id, $uid);
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

    function VerifiAllowTeamspeakVirtualServers(int $server_id, string $uid, ?array $AllowTeamspeakVirtualServers): bool
    {
        if (empty($AllowTeamspeakVirtualServers))
            return false;

        for ($i = 0; $i < count($AllowTeamspeakVirtualServers); $i++)
            if ($server_id === $AllowTeamspeakVirtualServers[$i]['instance_id'] && $uid === $AllowTeamspeakVirtualServers[$i]['unique_id'])
                return true;

        return false;
    }
}
