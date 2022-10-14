<?php

namespace App\Http\Middleware;

use Closure;

class AssignGuard
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $request->attributes->set('guard', $guard);

        if (null != $guard) {
            auth()->shouldUse($guard);
        }

        return $next($request);
    }
}
