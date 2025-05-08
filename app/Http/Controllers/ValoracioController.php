<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracio;

class ValoracioController extends Controller
{
    public function getValoracioByProductId(string $productId)
    {
        // Buscar valoració per producte id
        $valoracio = Valoracio::where('producte_id', $productId)->first();

        // Mostrar valoració
        if ($valoracio) {
            return response()->json($valoracio);
        }

        // No s'ha trobat valoració
        return response()->json(['error' => 'No s\'ha trobat la valoració'], 404);
    }
}
