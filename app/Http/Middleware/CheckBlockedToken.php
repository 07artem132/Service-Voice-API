<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 07.07.2017
 * Time: 15:43
 */

namespace Api\Http\Middleware;

use Api\Exceptions\TokenBlocked;
use Api\UserToken;
use Closure;

class CheckBlockedToken
{

    public function handle($request, Closure $next)
    {
        try {
            $token = $request->header('X-token');
            $tokenDB = UserToken::Token($token)->firstOrFail();
            if ($tokenDB->Blocked === 1) {
                throw new TokenBlocked();
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new InvalidToken();
        }

        return $next($request);
    }

}
