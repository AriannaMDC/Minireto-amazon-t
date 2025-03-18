<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MetodePagament;
use Illuminate\Support\Facades\Auth;


class PaymentMethodUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Els admin poden accedir a tots els metodes de pagament
        if ($user->rol === 'admin') {
            return $next($request);
        }

        // Un usuari nomes podra accedir als seus propis metodes de pagament
        if ($request->route('id')) {
            $paymentMethod = MetodePagament::find($request->route('id'));
            if (!$paymentMethod || $paymentMethod->usuari_id !== $user->id) {
                return response()->json(['error' => 'No autoritzat'], 403);
            }
        }

        return $next($request);
    }
}
