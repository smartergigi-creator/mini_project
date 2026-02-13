<?php

namespace App\Http\Middleware;

use Closure;

class GuestMiddleware
{
   public function handle($request, Closure $next)
{
    $token = $request->cookie('jwt_token');

    if ($token) {
        return redirect('/dashboard');
    }

    return $next($request);
}


}
