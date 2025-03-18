<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckVendorRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Nomes podran accedir els usuaris amb rol 'vendedor' o 'admin'
        if (!$user || ($user->rol !== 'vendedor' && $user->rol !== 'admin')) {
            return response()->json(['message' => 'No autoritzat', $user->rol], 403);
        }

        return $next($request);
    }
}
