<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentari;
use App\Models\Valoracio;
use App\Models\Caracteristica;
use Illuminate\Support\Str;

class ComentariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getAllByProductId(string $productId)
    {
        $comments = Comentari::where('producte_id', $productId)->get();
        if (!$comments) {
            return response()->json(['error' => 'No s\'han trobat comentaris per aquest producte'], 500);
        }
        return response()->json($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'valoracio' => 'required|integer|min:1|max:5',
            'comentari' => 'required|string',
            'imatges' => 'nullable|array',
            'imatges.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'model' => 'required|string',
            'usuari_id' => 'required|exists:users,id',
            'producte_id' => 'required|exists:productes,id',
        ]);

        // Load the product and check if the model matches
        $caracteristica = Caracteristica::where('producte_id', $request->producte_id)->first();
        if (!$caracteristica || $caracteristica->nom !== $request->model) {
            return response()->json(['error' => 'El model especificat no coincideix amb el nom del producte'], 400);
        }

        $imatgesPaths = [];
        if ($request->has('imatges')) {
            foreach ($request->file('imatges') as $imatge) {
                $imageName = Str::random(32) . '.' . $imatge->getClientOriginalExtension();
                $imatge->move(public_path('images/comments'), $imageName);
                $imatgesPaths[] = 'images/comments/' . $imageName;
            }
        }

        $comentari = new Comentari();
        $comentari->valoracio = $request->valoracio;
        $comentari->comentari = $request->comentari;
        $comentari->imatges = json_encode($imatgesPaths);
        $comentari->model = $request->model;
        $comentari->usuari_id = $request->usuari_id;
        $comentari->producte_id = $request->producte_id;

        if ($comentari->save()) {
            $valoracio = Valoracio::firstOrNew(['producte_id' => $request->producte_id]);
            $valoracio->mitja_valoracions = Comentari::where('producte_id', $request->producte_id)->avg('valoracio');
            $valoracio->{'total_' . $request->valoracio . '_estrelles'} += 1;
            $valoracio->total_comentaris += 1;

            if ($valoracio->save()) {
                return response()->json($comentari, 201);
            }
        }

        return response()->json(['error' => 'No s\'ha pogut guardar el comentari'], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'valoracio' => 'required|integer|min:1|max:5',
            'comentari' => 'required|string',
            'imatges' => 'nullable|array',
            'imatges.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'model' => 'required|string',
        ]);

        $comentari = Comentari::findOrFail($id);

        $caracteristica = Caracteristica::where('producte_id', $comentari->producte_id)->first();
        if (!$caracteristica || $caracteristica->nom !== $request->model) {
            return response()->json(['error' => 'El model especificat no coincideix amb el nom del producte'], 400);
        }

        $oldValoracio = $comentari->valoracio;

        if ($comentari->imatges) {
            $oldImages = json_decode($comentari->imatges, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        $imatgesPaths = [];
        if ($request->has('imatges')) {
            foreach ($request->file('imatges') as $imatge) {
                $imageName = Str::random(32) . '.' . $imatge->getClientOriginalExtension();
                $imatge->move(public_path('images/comments'), $imageName);
                $imatgesPaths[] = 'images/comments/' . $imageName;
            }
        }

        $comentari->valoracio = $request->valoracio;
        $comentari->comentari = $request->comentari;
        $comentari->imatges = json_encode($imatgesPaths);
        $comentari->model = $request->model;

        if ($comentari->save()) {
            $valoracio = Valoracio::firstOrNew(['producte_id' => $comentari->producte_id]);
            $valoracio->{'total_' . $oldValoracio . '_estrelles'} -= 1;
            $valoracio->{'total_' . $request->valoracio . '_estrelles'} += 1;
            $valoracio->mitja_valoracions = Comentari::where('producte_id', $comentari->producte_id)->avg('valoracio');
            $valoracio->total_comentaris += 1;

            if ($valoracio->save()) {
                return response()->json($comentari, 200);
            }
        }

        return response()->json(['error' => 'No s\'ha pogut actualitzar el comentari'], 500);
    }

    public function incrementUtil(string $id)
    {
        $comentari = Comentari::findOrFail($id);
        $comentari->util += 1;

        if ($comentari->save()) {
            return response()->json($comentari->util, 200);
        }

        return response()->json(['error' => 'No s\'ha pogut actualitzar el comentari'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comentari = Comentari::findOrFail($id);
        $oldValoracio = $comentari->valoracio;
        $producteId = $comentari->producte_id;

        // Delete associated images
        if ($comentari->imatges) {
            $oldImages = json_decode($comentari->imatges, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        if ($comentari->delete()) {
            $valoracio = Valoracio::firstOrNew(['producte_id' => $producteId]);
            $valoracio->{'total_' . $oldValoracio . '_estrelles'} -= 1;
            $valoracio->total_comentaris -= 1;
            $valoracio->mitja_valoracions = Comentari::where('producte_id', $producteId)->avg('valoracio') ?? 0;

            if ($valoracio->save()) {
                return response()->json(['message' => 'Comentari eliminat correctament'], 200);
            }
        }

        return response()->json(['error' => 'No s\'ha pogut eliminar el comentari'], 500);
    }
}
