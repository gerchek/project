<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::guest()) {
            return redirect('/');
        }

        if (! $request->user()->hasAnyRole($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
