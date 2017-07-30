<?php

namespace Api\Http\Middleware;

use Api\Exceptions\AuthenticationException;
use Sentinel;
use Closure;
use Auth;
use Api\UserToken;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {

        $token = $request->header('X-token');
        $tokenDB = UserToken::Token($token)->firstOrFail();
        $TokenPrivileges = json_decode($tokenDB->privileges->privilege);

        if (!array_key_exists($permissions, $TokenPrivileges)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Нет привилегии: ' . $permissions
            ]);
        }

        return $next($request);
    }

}
