<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePagament;
use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;

class MetodePagamentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipus' => 'required|in:visa,paypal,mastercard',
            'titular' => 'required',
            'numero' => 'required|digits:16',
            'caducitat' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
            'cvv' => 'required|digits:3',
        ]);

        // Afegir el id del usuari que ha iniciat sessio
        $validated['usuari_id'] = Auth::user()->id;

        // Crear el mètode de pagament
        $metodePagament = MetodePagament::create($validated);

        return response()->json($metodePagament, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el mètode de pagament per id
        $metodePagament = MetodePagament::find($id);

        // Retornar error si no s'ha trobat el mètode de pagament
        if(!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no trobat'], 404);
        }

        return response()->json($metodePagament, 200);
    }

    /**
     * Display the specified resource by user ID.
     */
    public function getByUserId()
    {
        // Buscar el mètode de pagament per el id del usuari autenticat
        $usuari_id = Auth::user()->id;
        $metodesPagament = MetodePagament::where('usuari_id', $usuari_id)->get();

        return response()->json($metodesPagament, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tipus' => 'required|in:visa,paypal,mastercard',
            'titular' => 'required',
            'numero' => 'required|digits:16',
            'caducitat' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
            'cvv' => 'required|digits:3'
        ]);

        // Buscar el mètode de pagament per id
        $metodePagament = MetodePagament::find($id);

        // Retornar error si no s'ha trobat el mètode de pagament
        if(!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no trobat'], 404);
        }

        // Actualitzar el mètode de pagament
        $metodePagament->update($validated);

        return response()->json($metodePagament, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el mètode de pagament per id
        $metodePagament = MetodePagament::find($id);

        // Retornar error si no s'ha trobat el mètode de pagament
        if(!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no trobat'], 404);
        }

        // Eliminar el mètode de pagament
        $metodePagament->delete();

        return response()->json(['message' => 'Mètode de pagament eliminat correctament'], 200);
    }

    /**
     * Processa el pagament i completa la comanda del carrito utilitzant el mètode de pagament especificat.
     * Valida que el mètode de pagament pertanyi a l'usuari autenticat,
     * comprova si hi ha un carrito actiu i el marca com a completat.
     */
    public function completar(Request $request)
    {
        $request->validate([
            'metode_pagament_id' => 'required',
        ]);

        // Obtenir el metode de pagament i verificar que pertany a l'usuari autenticat
        $metodePagament = MetodePagament::where('id', $request->metode_pagament_id)
            ->where('usuari_id', Auth::user()->id)
            ->first();

        // El metode de pagament no existeix o no pertany a l'usuari
        if (!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no vàlid'], 404);
        }

        // Obtenir el carrito no completat de l'usuari
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->first();

        // No hi ha ningun carrito no completat
        if (!$carrito) {
            return response()->json(['message' => 'No hi ha cap carrito actiu'], 404);
        }

        // Actualitzar carrito com a completat
        $carrito->completat = true;
        $carrito->metode_pagament_id = $metodePagament->id;

        // Guardar carrito
        if (!$carrito->save()) {
            return response()->json(['message' => 'Error al processar el pagament'], 500);
        }

        // Carrito guradat correctament
        return response()->json(['message' => 'Pagament processat i comanda completada correctament']);
    }
}
