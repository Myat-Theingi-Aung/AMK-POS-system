<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $adminRole): Response
    {
        $roles = Auth::check() ? [Auth::user()->role] : [];

        if (!in_array($adminRole, $roles)) {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
