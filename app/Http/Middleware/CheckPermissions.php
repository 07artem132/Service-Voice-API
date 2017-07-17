<?php

namespace Api\Http\Middleware;

use Api\Exceptions\AuthenticationException;
use Sentinel;
use Closure;
use Auth;

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
        if (!Sentinel::findById(Auth::id())->hasAccess(explode(':', $permissions))) {

            return response()->json([
                'status' => 'error',
                'message' => 'Нет привилегии: ' . $permissions
            ]);
        }

        return $next($request);
    }

}
