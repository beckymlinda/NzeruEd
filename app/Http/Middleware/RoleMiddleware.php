<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Example usage: role:student or role:admin
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || $user->role !== $role) {
            // Option 1: 403 Forbidden
            // abort(403, 'Unauthorized');

            // Option 2: 404 Not Found (common for hiding pages)
            abort(404);
        }

        return $next($request);
    }
}
