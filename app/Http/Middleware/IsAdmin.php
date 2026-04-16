<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika dia belum login, atau role-nya bukan admin, usir ke beranda!
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Halaman ini khusus untuk Admin Pengelola Beasiswa KIP.');
        }

        return $next($request);
    }
}