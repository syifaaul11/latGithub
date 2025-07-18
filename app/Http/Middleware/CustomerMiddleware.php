<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isCustomer()) {
            return redirect()->route('login')->with('error', 'Akses ditolak! Anda harus login sebagai customer.');
        }

        return $next($request);
    }
}