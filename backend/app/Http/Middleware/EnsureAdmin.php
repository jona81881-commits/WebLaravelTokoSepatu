<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Hanya admin yang boleh mengakses.'], 403);
            }

            abort(403, 'Hanya admin yang boleh mengakses halaman ini.');
        }

        return $next($request);
    }
}
