<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'destacat' => 'nullable|boolean',
            'caracteristiques' => 'nullable|array',
            'caracteristiques.*.nom' => 'required',
            'caracteristiques.*.propietats' => 'required|json',
            'caracteristiques.*.img' => 'nullable|array',
            'caracteristiques.*.img.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['vendedor_id'] = Auth::user()->id;

        $producte = Producte::create($validated);

        if (isset($validated['caracteristiques'])) {
            foreach ($validated['caracteristiques'] as $caracteristica) {
                if (isset($caracteristica['img'])) {
                    $imagePaths = [];
                    foreach ($caracteristica['img'] as $image) {
                        $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('images/products'), $imageName);
                        $imagePaths[] = 'images/products/' . $imageName;
                    }
                    $caracteristica['img'] = json_encode($imagePaths);
                }
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
            'oferta' => 'nullable|integer|min:0',
            'categoria_id' => 'required|exists:categories,id',
            'destacat' => 'nullable|boolean',
            'caracteristiques' => 'nullable|array',
            'caracteristiques.*.nom' => 'required_with:caracteristiques',
            'caracteristiques.*.propietats' => 'required_with:caracteristiques|json',
            'caracteristiques.*.img' => 'required_with:caracteristiques|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producte = Producte::find($id);

        if ($producte) {
            $producte->update($validated);

            if (isset($validated['caracteristiques'])) {
                $producte->caracteristiques()->delete();
                foreach ($validated['caracteristiques'] as $caracteristica) {
                    if (isset($caracteristica['img'])) {
                        $imageName = Str::random(32) . '.' . $caracteristica['img']->getClientOriginalExtension();
                        $caracteristica['img']->move(public_path('images/products'), $imageName);
                        $caracteristica['img'] = 'images/products/' . $imageName;
                    }
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
