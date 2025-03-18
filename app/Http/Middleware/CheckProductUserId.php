<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Producte;

class CheckProductUserId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $productId = $request->route('id');
        $product = Producte::find($productId);

        // Els admin podem accedir a tots els productes
        if($user->rol === 'admin') {
            return $next($request);
        }

        // Si el producte no existeix
        if(!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Un vendedor nomes podra accedir als seus propis productes
        if(!$user || $user->rol !== 'vendedor' || $product->vendedor_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized', $user->rol], 403);
        }

        return $next($request);
    }
}
