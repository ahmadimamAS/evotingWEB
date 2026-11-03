<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SiswaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('siswa')->check() || !Auth::user() instanceof \App\Models\Siswa) {
            return redirect('/siswa/login')->with('error', 'Silakan login sebagai siswa terlebih dahulu');
        }

        return $next($request);
    }
}

