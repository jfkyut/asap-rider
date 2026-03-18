<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsFaceVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Ensure we're checking the currently authenticated user (not querying the users table generally)
        if (! $user || $user->face_verified_at === null) {
            return redirect()->route('face-verification.index');
        }

        return $next($request);
    }
}
