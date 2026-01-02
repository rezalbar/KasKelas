<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user yang login itu 'admin'
        if (auth()->check() && auth()->user()->role == 'admin') {
            return $next($request); // Silakan masuk bos!
        }

        // Kalau bukan admin, tendang ke dashboard atau kasih error
        return redirect('/dashboard')->with('error', 'Anda tidak punya akses ke halaman tersebut!');
    }
}