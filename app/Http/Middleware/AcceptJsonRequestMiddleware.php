<?php

namespace App\Http\Middleware;

use Closure;

class AcceptJsonRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! $request->wantsJson())   // lumen: isJson()
            return response('Unauthorized', 401);
        return $next($request);
    }
}
