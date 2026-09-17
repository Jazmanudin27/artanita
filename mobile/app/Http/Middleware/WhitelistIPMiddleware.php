<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class WhitelistIPMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedIPs = ['103.208.207.144', '103.208.207.145'];

        $clientIP = Request::ip();

        if (in_array($clientIP, $allowedIPs)) {
            return $next($request);
        }

        return response('Unauthorized. Your IP is not whitelisted.', 403);
    }
}