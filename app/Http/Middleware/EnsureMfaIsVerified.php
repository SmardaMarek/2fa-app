<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMfaIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Allow MFA routes, logout, and verification routes
        if ($request->routeIs('mfa.*') || $request->routeIs('logout') || $request->routeIs('verification.*')) {
            return $next($request);
        }

        if (!$user->hasMfaEnabled()) {
            return redirect()->route('mfa.setup');
        }

        if (!session('mfa_verified')) {
            return redirect()->route('mfa.challenge');
        }

        return $next($request);
    }
}
