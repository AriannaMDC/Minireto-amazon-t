<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producte;

class ProducteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $productes = Producte::all();

        return response()->json($productes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'descr' => 'nullable|string',
            'valoracio' => 'nullable|numeric|min:0|max:5',
            'num_resenyes' => 'nullable|integer|min:0',
            'preu' => 'required|numeric|min:0',
            'enviament' => 'required|numeric|min:0',
            'dies' => 'required|integer|min:0',
            'devolucio' => 'required|boolean',
            'devolucioGratis' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'categoriaId' => 'required|exists:categories,id',
        ]);

        $producte = Producte::create($validatedData);

        if ($producte) {
            return response()->json($producte, 201);
        } else {
            return response()->json(['error' => 'Product could not be created'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producte = Producte::find($id);

        if ($producte) {
            return response()->json($producte, 200);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'descr' => 'nullable|string',
            'valoracio' => 'nullable|numeric|min:0|max:5',
            'num_resenyes' => 'nullable|integer|min:0',
            'preu' => 'required|numeric|min:0',
            'enviament' => 'required|numeric|min:0',
            'dies' => 'required|integer|min:0',
            'devolucio' => 'required|boolean',
            'devolucioGratis' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'categoriaId' => 'required|exists:categories,id',
        ]);

        $producte = Producte::find($id);

        if ($producte) {
            $producte->update($validatedData);
            return response()->json($producte, 200);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producte = Producte::find($id);

        if ($producte) {
            $producte->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}
