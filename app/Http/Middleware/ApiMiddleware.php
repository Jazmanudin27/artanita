<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->header('Authorization') || !(Auth::guard('api_guru')->check() || Auth::guard('api')->check() || Auth::guard('api_siswa')->check())) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);

    }
}
