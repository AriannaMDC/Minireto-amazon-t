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
        $user = $request->user();

        if ($user->rol === 'admin') {
            return $next($request);
        }

        if ($request->route('id')) {
            $paymentMethod = MetodePagament::find($request->route('id'));
            if (!$paymentMethod || $paymentMethod->user_id !== $user->id) {
                return response()->json(['error' => 'No autoritzat'], 403);
            }
        }

        if ($request->route('usuari_id')) {
            if ($request->route('usuari_id') != $user->id) {
                return response()->json(['error' => 'No autoritzat'], 403);
            }
        }

        return $next($request);
    }
}
