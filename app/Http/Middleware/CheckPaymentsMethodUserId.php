<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\MetodePagament;

class CheckPaymentsMethodUserId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $userIdRoute = $request->route('id');

        // Un usuario nomes podra accedir als seus propis metodes de pagament
        if (!$userIdRoute || $user->id != $userIdRoute) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
