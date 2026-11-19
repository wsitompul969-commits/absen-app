<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAdminAuthRoute = $request->routeIs('filament.admin.auth.*')
            || $request->is('admin/login')
            || $request->is('admin/login/*')
            || in_array($request->path(), ['admin/login', '/admin/login'], true);

        if ($isAdminAuthRoute) {
            return $next($request);
        }

        if (! auth()->check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        if (! auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke panel admin.');
        }

        return $next($request);
    }
}
