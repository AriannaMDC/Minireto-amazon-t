<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mostrar totes les categories o nomes les novetats (per la pagina inici)
        $destacat = $request->query('destacat');

        // Mostrar categories destacades
        if($destacat === 'true') {
            $categories = Categoria::where('destacat', true)->get(['id', 'name', 'img']);
        } else { // Mostrar totes les categories
            $categories = Categoria::select('id', 'name', 'img')->get();
        }

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($request->hasFile('img')) { // Comprovar que s'ha enviat una imatge
            // Guardar la imatge a public/images/categories
            $image = $request->file('img');
            $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);

            // Crear la categoria amb la imatge
            $categoria = Categoria::create([
                'name' => $request->input('name'),
                'img' => 'images/categories/' . $imageName,
            ]);

            // Retornar la categoria creada
            if($categoria) {
                return response()->json($categoria, 200);
            }
        }

        // Retornar error si no s'ha pogut crear la categoria
        return response()->json(['error' => 'Error en crear la categoria'], 505);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar la categoria per id
        $categoria = Categoria::select('id', 'name', 'img')->find($id);

        // Si no existeix la categoria retornar error
        if(!$categoria) {
            return response()->json(['error' => 'Categoria no trobada'], 404);
        }

        return response()->json($categoria, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Buscar la categoria per id
        $categoria = Categoria::find($id);

        // Si no existeix la categoria retornar error
        if(!$categoria) {
            return response()->json(['error' => 'Categoria no trobada'], 404);
        }

        // Actualitzar la imatge si s'ha enviat una nova
        if($request->hasFile('img')) {
            // Eliminar la imatge anterior
            if($categoria->img && file_exists(public_path($categoria->img))) {
                unlink(public_path($categoria->img));
            }

            // Guardar la nova imatge
            $image = $request->file('img');
            $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);

            $categoria->img = 'images/categories/' . $imageName;
        }

        // Actualitzar la categoria
        $categoria->name = $request->input('name');
        $categoria->save();

        return response()->json($categoria, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        // Buscar la categoria per id
        $categoria = Categoria::find($id);

        // Si no existeix la categoria retornar error
        if(!$categoria) {
            return response()->json(['error' => 'Categoria no trobada'], 404);
        }

        // Eliminar la imatge de la categoria
        if($categoria->img && file_exists(public_path($categoria->img))) {
            unlink(public_path($categoria->img));
        }

        // Eliminar la categoria
        $categoria->delete();

        return response()->json(['message' => 'Categoria eliminada'], 200);
    }
}
