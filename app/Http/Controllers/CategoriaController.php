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
        $destacat = $request->query('destacat');

        if ($destacat === 'true') {
            $categories = Categoria::where('destacat', true)->get();
        } else {
            $categories = Categoria::all();
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

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);

            $categoria = Categoria::create([
                'name' => $request->input('name'),
                'img' => 'images/categories/' . $imageName,
            ]);

            if ($categoria) {
                return response()->json($categoria, 200);
            }
        }

        return response()->json(['error' => 'Error en crear la categoria'], 505);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
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

        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoria no trobada'], 404);
        }

        if ($request->hasFile('img')) {
            // Delete the previous image
            if ($categoria->img && file_exists(public_path($categoria->img))) {
                unlink(public_path($categoria->img));
            }

            // Store the new image with a random name
            $image = $request->file('img');
            $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);

            $categoria->img = 'images/categories/' . $imageName;
        }

        $categoria->name = $request->input('name');
        $categoria->save();

        return response()->json($categoria, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoria no trobada'], 404);
        }

        // Delete the associated image
        if ($categoria->img && file_exists(public_path($categoria->img))) {
            unlink(public_path($categoria->img));
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoria eliminada'], 200);
    }
}
