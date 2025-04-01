<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracio;

class ValoracioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
