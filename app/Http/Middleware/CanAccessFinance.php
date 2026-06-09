<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanAccessFinance
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || !$user->hasFinanceAccess()) {
            // Content admins go to their own dashboard
            if ($user && $user->isContentAdmin()) {
                return redirect()->route('admin.news.index');
            }
            abort(403, 'Akses tidak diizinkan.');
        }
        return $next($request);
    }
}