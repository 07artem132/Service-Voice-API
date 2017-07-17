<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 06.07.2017
 * Time: 19:47
 */

namespace Api\Http\Middleware;

use Api\Exceptions\InvalidToken;
use Api\Exceptions\NotSpecified;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Api\UserToken;
use Closure;
use Auth;

class TokenVerifi
{

    public function handle($request, Closure $next)
    {
        try {
            $token = $request->header('X-token');
            if (empty($token))
                throw new NotSpecified('X-token');

            $tokenDB = UserToken::Token($token)->firstOrFail();

            AUTH::onceUsingId($tokenDB->user_id);

        } catch (ModelNotFoundException $e) {
            throw new InvalidToken();
        }

        return $next($request);
    }

}
