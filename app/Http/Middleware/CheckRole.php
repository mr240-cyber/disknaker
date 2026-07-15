<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            // Redirect based on actual role
            if ($request->user() && $request->user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/dashboard');
        }

        return $next($request);
    }
}
