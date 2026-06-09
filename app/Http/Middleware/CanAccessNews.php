<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanAccessNews
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || (!$user->isAdmin() && !$user->isContentAdmin())) {
            abort(403, 'Akses tidak diizinkan.');
        }
        return $next($request);
    }
}