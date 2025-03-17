<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $destacat = $request->query('destacat');

        if ($destacat === 'true') {
            $categories = Categoria::where('destacat', true)->get();
        } else {
            $categories = Categoria::all();
        }

        return response()->json($categories, 200);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'img' => 'required|string',
    //     ]);

    //     $categoria = Categoria::create($request->all());

    //     if ($categoria) {
    //         return response()->json($categoria, 200);
    //     }

    //     return response()->json(['error' => 'Error al crear la categoria'], 505);
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     $categoria = Categoria::find($id);

    //     if (!$categoria) {
    //         return response()->json(['error' => 'Categoria not found'], 404);
    //     }

    //     return response()->json($categoria, 200);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'img' => 'required|string',
    //     ]);

    //     $categoria = Categoria::find($id);

    //     if (!$categoria) {
    //         return response()->json(['error' => 'Categoria not found'], 404);
    //     }

    //     $categoria->update($request->all());

    //     return response()->json($categoria, 200);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id) {
    //     $categoria = Categoria::find($id);

    //     if (!$categoria) {
    //         return response()->json(['error' => 'Categoria not found'], 404);
    //     }

    //     $categoria->delete();

    //     return response()->json(['message' => 'Categoria deleted'], 200);
    // }
}
