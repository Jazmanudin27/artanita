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
        if (Auth::check() && Auth::user()->role == 'Admin') {
            return $next($request);
        }
        return redirect('/');
    }
}
