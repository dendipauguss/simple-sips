<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AktifUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status == 0) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['Akun anda telah dinonaktifkan.']);
        }

        return $next($request);
    }
}
