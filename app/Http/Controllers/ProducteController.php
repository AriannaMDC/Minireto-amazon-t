<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producte;

class ProducteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $destacat = $request->query('destacat');

        if ($destacat === 'true') {
            $productes = Producte::with(['categoria', 'caracteristiques'])->where('destacat', true)->get();
        } else {
            $productes = Producte::with(['categoria', 'caracteristiques'])->get();
        }

        return response()->json($productes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'descr' => 'nullable',
            'valoracio' => 'nullable|numeric|min:0|max:5',
            'num_resenyes' => 'nullable|integer|min:0',
            'preu' => 'required|numeric|min:0',
            'enviament' => 'required|numeric|min:0',
            'dies' => 'required|integer|min:0',
            'devolucio' => 'required|boolean',
            'devolucioGratis' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categories,id',
            'caracteristiques' => 'nullable|array',
            'caracteristiques.*.nom' => 'required',
            'caracteristiques.*.propietats' => 'required|json',
            'caracteristiques.*.img' => 'required|json',
        ]);

        $validated['vendor_id'] = auth()->user()->id;

        $producte = Producte::create($validated);

        if (isset($validated['caracteristiques'])) {
            foreach ($validated['caracteristiques'] as $caracteristica) {
                $producte->caracteristiques()->create($caracteristica);
            }
        }

        if ($producte) {
            return response()->json($producte->load('caracteristiques'), 200);
        } else {
            return response()->json(['error' => 'Product could not be created'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producte = Producte::with(['categoria', 'caracteristiques'])->find($id);

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
            'nom' => 'required',
            'descr' => 'nullable',
            'valoracio' => 'nullable|numeric|min:0|max:5',
            'num_resenyes' => 'nullable|integer|min:0',
            'preu' => 'required|numeric|min:0',
            'enviament' => 'required|numeric|min:0',
            'dies' => 'required|integer|min:0',
            'devolucio' => 'required|boolean',
            'devolucioGratis' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'oferta' => 'nullable|integer|min:0',
            'categoria_id' => 'required|exists:categories,id',
            'caracteristiques' => 'nullable|array',
            'caracteristiques.*.nom' => 'required_with:caracteristiques',
            'caracteristiques.*.propietats' => 'required_with:caracteristiques|json',
            'caracteristiques.*.img' => 'required_with:caracteristiques|json',
        ]);

        $producte = Producte::find($id);

        if ($producte) {
            $validatedData['vendor_id'] = auth()->user()->id;
            $producte->update($validatedData);

            if (isset($validatedData['caracteristiques'])) {
                $producte->caracteristiques()->delete();
                foreach ($validatedData['caracteristiques'] as $caracteristica) {
                    $producte->caracteristiques()->create($caracteristica);
                }
            }

            return response()->json($producte->load('caracteristiques'), 200);
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
