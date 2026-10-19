<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika admin membuka halaman pelanggan,
        // arahkan kembali ke dashboard admin.
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Role selain pelanggan tidak boleh membuka halaman pelanggan.
        if (auth()->user()->role !== 'pelanggan') {
            abort(403, 'Akses ditolak! Khusus pelanggan.');
        }

        return $next($request);
    }
}
