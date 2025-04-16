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
        // Mostrar tots els productes o nomes les novetats (per la pagina inici)
        $destacat = $request->query('destacat');

        // Mostrar productes destacats
        if($destacat === 'true') {
            $productes = Producte::with(['caracteristiques'])->where('destacat', true)->get();
        } else { // Mostrar tots els productes
            $productes = Producte::with(['caracteristiques'])->get();
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
            'preu' => 'required|numeric|min:0',
            'enviament' => 'required|numeric|min:0',
            'dies' => 'required|integer|min:0',
            'devolucio' => 'required|boolean',
            'devolucioGratis' => 'required|boolean',
            'categoria_id' => 'required|exists:categories,id',
            'destacat' => 'nullable|boolean',
            'caracteristiques' => 'required|array',
            'caracteristiques.*.nom' => 'required',
            'caracteristiques.*.propietats' => 'required|json',
            'caracteristiques.*.img' => 'required|array',
            'caracteristiques.*.img.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caracteristiques.*.stock' => 'required|integer|min:0',
        ]);

        // Afegir el id del usuari que ha iniciat sessio
        $validated['vendedor_id'] = Auth::user()->id;

        // Crear el producte
        $producte = Producte::create($validated);

        // Crear les caracteristiques del producte
        if(isset($validated['caracteristiques'])) {
            foreach ($validated['caracteristiques'] as $caracteristica) {
                if(isset($caracteristica['img'])) { // Guardar imatges
                    $imagePaths = [];
                    foreach ($caracteristica['img'] as $image) {
                        $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('images/products'), $imageName);
                        $imagePaths[] = 'images/products/' . $imageName;
                    }
                    $caracteristica['img'] = json_encode($imagePaths);
                }
                // Crear la caracteristica
                $producte->caracteristiques()->create($caracteristica);
            }
        }

        // Retornar el producte creat
        if($producte) {
            return response()->json($producte->load('caracteristiques'), 200);
        }

        // Retornar error si no s'ha pogut crear el producte
        return response()->json(['error' => 'El producte no s\'ha pogut crear'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el producte per id
        $producte = Producte::with(['caracteristiques'])->find($id);

        // Retornar el producte
        if($producte) {
            return response()->json($producte, 200);
        }

        // Retornar error si no s'ha trobat el producte
        return response()->json(['error' => 'Producte no trobat'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'descr' => 'nullable',
            'preu' => 'required|numeric|min:0',
            'enviament' => 'required|numeric|min:0',
            'dies' => 'required|integer|min:0',
            'devolucio' => 'required|boolean',
            'devolucioGratis' => 'required|boolean',
            'oferta' => 'nullable|integer|min:0',
            'categoria_id' => 'required|exists:categories,id',
            'destacat' => 'nullable|boolean',
            'caracteristiques' => 'nullable|array',
            'caracteristiques.*.nom' => 'required',
            'caracteristiques.*.propietats' => 'required|json',
            'caracteristiques.*.img' => 'nullable|array',
            'caracteristiques.*.img.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caracteristiques.*.stock' => 'required|integer|min:0',
        ]);

        // Buscar el producte per id
        $producte = Producte::with('caracteristiques')->find($id);

        // Actualitzar el producte
        if($producte) {
            $producte->update($validated);

            // Actualitzar les caracteristiques del producte
            if(isset($validated['caracteristiques'])) {
                // Eliminar les imatges antigues
                foreach ($producte->caracteristiques as $caracteristica) {
                    if(isset($caracteristica->img)) {
                        $images = json_decode($caracteristica->img, true);
                        if(is_array($images)) {
                            foreach ($images as $imagePath) {
                                if(file_exists(public_path($imagePath))) {
                                    unlink(public_path($imagePath));
                                }
                            }
                        }
                    }
                }
                $producte->caracteristiques()->delete();

                // Crear les noves caracteristiques
                foreach ($validated['caracteristiques'] as $caracteristica) {
                    if(isset($caracteristica['img'])) {
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

            // Retornar el producte actualitzat
            return response()->json($producte->load('caracteristiques'), 200);
        }

        // Retornar error si no s'ha trobat el producte
        return response()->json(['error' => 'Producte no trobat'], 404);
    }

    public function destroy(string $id)
    {
        // Buscar el producte per id
        $producte = Producte::find($id);

        // Eliminar el producte
        if($producte) {
            // Eliminar les imatges del producte
            foreach ($producte->caracteristiques as $caracteristica) {
                if(isset($caracteristica->img)) {
                    $images = json_decode($caracteristica->img, true);
                    if(is_array($images)) {
                        foreach ($images as $imagePath) {
                            if(file_exists(public_path($imagePath))) {
                                unlink(public_path($imagePath));
                            }
                        }
                    }
                }
            }

            // Eliminar el producte
            $producte->delete();
            return response()->json(['message' => 'Producte eliminat correctament'], 200);
        }

        // Retornar error si no s'ha trobat el producte
        return response()->json(['error' => 'Producte no trobat'], 404);
    }

    public function getByCategoryID(string $categoria_id)
    {
        // Buscar productes per categoria_id
        $productes = Producte::with(['caracteristiques'])->where('categoria_id', $categoria_id)->get();

        // Retornar els productes
        if ($productes) {
            return response()->json($productes, 200);
        }

        // Retornar error si no s'han trobat productes
        return response()->json(['error' => 'No s\'han trobat productes per aquesta categoria'], 404);
    }

    public function getByText(Request $request)
    {
        $text = $request->query('text');

        // Validar que el text no sigui buit
        if (!$text) {
            return response()->json(['error' => 'El text és requerit'], 400);
        }

        // Buscar productes que continguin el text al nom
        $productes = Producte::with(['caracteristiques'])->where('nom', 'like', '%' . $text . '%')->get();

        // Retornar els productes
        if ($productes) {
            return response()->json($productes, 200);
        }

        // Retornar error si no s'han trobat productes
        return response()->json(['error' => 'No s\'han trobat productes amb aquest text'], 404);
    }

    public function getProductesVendedor()
    {
        // Obtenir productes vendedor
        $productes = Producte::with(['caracteristiques'])->where('vendedor_id', Auth::user()->id)->get();

        // Hi ha productes
        if ($productes->count() > 0) {
            return response()->json($productes, 200);
        }

        // No hi ha productes
        return response()->json(['error' => 'No s\'han trobat productes per aquest venedor'], 404);
    }
}
