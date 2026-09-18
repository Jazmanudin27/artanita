<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() || Auth::guard('web')->check() || Auth::guard('guru')->check() || Auth::guard('kelas')->check() || Auth::guard('siswa')->check()) {
            return $next($request);
        }
        return redirect('/');
    }
}
