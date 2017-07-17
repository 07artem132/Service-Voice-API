<?php

namespace Api\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Closure;
use Auth;

class NotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->guest()) {

            if ($request->fullUrl() != $request->headers->get('referer'))
                return Redirect::back()->withInput();

            return redirect('/')->withInput();
        }

        return $next($request);
    }
}
