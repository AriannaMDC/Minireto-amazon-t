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
        // Buscar comentari per producte id
        $comments = Comentari::where('producte_id', $productId)->get();

        // Mostrar comentaris
        if ($comments) {
            return response()->json($comments, 200);
        }

        // No s'han trobat comentaris
        return response()->json(['error' => 'No s\'han trobat comentaris per aquest producte'], 500);
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

        // Agafar totes les caracteristiques del producte i comprovar que el model existeix en el producte
        $caracteristiques = Caracteristica::where('producte_id', $request->producte_id)->pluck('nom')->toArray();
        if (!in_array($request->model, $caracteristiques)) {
            return response()->json(['error' => 'El model especificat no coincideix amb cap dels noms del producte'], 400);
        }

        // Guardar les imatges del comentari
        $imatgesPaths = [];
        if ($request->has('imatges')) {
            foreach ($request->file('imatges') as $imatge) {
                $imageName = Str::random(32) . '.' . $imatge->getClientOriginalExtension();
                $imatge->move(public_path('images/comments'), $imageName);
                $imatgesPaths[] = 'images/comments/' . $imageName;
            }
        }

        // Crear el comentari
        $comentari = new Comentari();
        $comentari->valoracio = $request->valoracio;
        $comentari->comentari = $request->comentari;
        $comentari->imatges = json_encode($imatgesPaths);
        $comentari->model = $request->model;
        $comentari->usuari_id = $request->usuari_id;
        $comentari->producte_id = $request->producte_id;

        // Guardar el comentari
        if ($comentari->save()) {
            $valoracio = Valoracio::firstOrNew(['producte_id' => $request->producte_id]); // Actualitzar la valoració del producte
            $valoracio->mitja_valoracions = Comentari::where('producte_id', $request->producte_id)->avg('valoracio'); // Actualitzar la la mitjana d'estrelles del producte
            $valoracio->{'total_' . $request->valoracio . '_estrelles'} += 1; // Actualitzar el total d'estrelles (1-5)
            $valoracio->total_comentaris += 1; // Actualitzar el total de comentaris

            // Guardar la valoració
            if ($valoracio->save()) {
                return response()->json($comentari, 201);
            }
        }

        // No s'ha pogut guardar el comentari o la valoració
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

        // Buscar el comentari
        $comentari = Comentari::findOrFail($id);

        // Agafar totes les caracteristiques del producte i comprovar que el model existeix en el producte
        $caracteristiques = Caracteristica::where('producte_id', $request->producte_id)->pluck('nom')->toArray();
        if (!in_array($request->model, $caracteristiques)) {
            return response()->json(['error' => 'El model especificat no coincideix amb cap dels noms del producte'], 400);
        }

        // Eliminar les imatges antigues
        if ($comentari->imatges) {
            $oldImages = json_decode($comentari->imatges, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        // Guardar les noves imatges del comentari
        $imatgesPaths = [];
        if ($request->has('imatges')) {
            foreach ($request->file('imatges') as $imatge) {
                $imageName = Str::random(32) . '.' . $imatge->getClientOriginalExtension();
                $imatge->move(public_path('images/comments'), $imageName);
                $imatgesPaths[] = 'images/comments/' . $imageName;
            }
        }

        // Actualitzar el comentari
        $comentari->valoracio = $request->valoracio;
        $comentari->comentari = $request->comentari;
        $comentari->imatges = json_encode($imatgesPaths);
        $comentari->model = $request->model;

        // Guardar el comentari
        if ($comentari->save()) {
            // Actualitzar la valoració del producte
            $valoracio = Valoracio::firstOrNew(['producte_id' => $comentari->producte_id]);

            // Eliminar -1 al numero d'estrelles anterior
            $oldValoracio = $comentari->valoracio;
            $valoracio->{'total_' . $oldValoracio . '_estrelles'} -= 1;

            // Afegir +1 al numero d'estrelles nou
            $valoracio->{'total_' . $request->valoracio . '_estrelles'} += 1;
            $valoracio->mitja_valoracions = Comentari::where('producte_id', $comentari->producte_id)->avg('valoracio'); // Actualitzar la mitjana d'estrelles del producte
            $valoracio->total_comentaris += 1; // Actualitzar el total de comentaris

            // Guardar la valoració
            if ($valoracio->save()) {
                return response()->json($comentari, 200);
            }
        }

        // No s'ha pogut guardar el comentari o la valoració
        return response()->json(['error' => 'No s\'ha pogut actualitzar el comentari'], 500);
    }

    public function updateUtil(string $id, Request $request)
    {
        // Incrementar o disminuir el valor del camp util
        $increment = request()->query('increment', true);

        // Buscar el comentari
        $comentari = Comentari::findOrFail($id);

        // Incrementar o disminuir el valor del camp util
        if ($increment) {
            $comentari->util += 1;
        } else {
            $comentari->util -= 1;
        }

        // Guardar el comentari
        if ($comentari->save()) {
            return response()->json($comentari, 200);
        }

        // No s'ha pogut guardar el comentari
        return response()->json(['error' => 'No s\'ha pogut actualitzar el comentari'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el comentari
        $comentari = Comentari::findOrFail($id);
        $oldValoracio = $comentari->valoracio; // Guardar la valoració
        $producteId = $comentari->producte_id; // Guardar el producte id

        // Eliminar les imatges antigues
        if ($comentari->imatges) {
            $oldImages = json_decode($comentari->imatges, true);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        // Eliminar el comentari
        if ($comentari->delete()) {
            // Actualitzar la valoració del producte
            $valoracio = Valoracio::firstOrNew(['producte_id' => $producteId]);

            $valoracio->{'total_' . $oldValoracio . '_estrelles'} -= 1; // Eliminar -1 al numero d'estrelles
            $valoracio->total_comentaris -= 1; // Actualitzar la mitjana d'estrelles del producte
            $valoracio->mitja_valoracions = Comentari::where('producte_id', $producteId)->avg('valoracio') ?? 0; // Actualitzar la mitja, si no hi ha comentaris, la mitjana es 0

            // Guardar la valoracio
            if ($valoracio->save()) {
                return response()->json(['message' => 'Comentari eliminat correctament'], 200);
            }
        }

        // No s'ha pogut eliminar el comentari o guardar la valoració
        return response()->json(['error' => 'No s\'ha pogut eliminar el comentari'], 500);
    }
}
