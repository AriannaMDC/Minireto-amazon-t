<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePagament;
use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Obtenir els últims 4 dígits abans del hash
        $lastFourDigits = substr($validated['numero'], -4);
        // Fer hash del número de targeta i afegir els últims 4 dígits
        $validated['numero'] = Hash::make($validated['numero']) . '_' . $lastFourDigits;

        // Crear el mètode de pagament
        $metodePagament = MetodePagament::create($validated);

        // Emmascarar el número en la resposta
        $metodePagament->numero = str_repeat('*', 12) . $lastFourDigits;

        return response()->json($metodePagament, 200);
    }

    /**
     * Mostra el recurs especificat.
     */
    public function show(string $id)
    {
        // Buscar el mètode de pagament per id
        $metodePagament = MetodePagament::find($id);

        // Retornar error si no s'ha trobat el mètode de pagament
        if(!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no trobat'], 404);
        }

        // Obtenir els últims 4 dígits del número emmagatzemat
        $lastFourDigits = substr($metodePagament->numero, strrpos($metodePagament->numero, '_') + 1);

        // Emmascarar el número
        $metodePagament->numero = str_repeat('*', 12) . $lastFourDigits;

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

        // Emmascarar els números de targeta
        foreach ($metodesPagament as $metodePagament) {
            $lastFourDigits = substr($metodePagament->numero, strrpos($metodePagament->numero, '_') + 1);
            $metodePagament->numero = str_repeat('*', 12) . $lastFourDigits;
        }

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

        // Obtenir els últims 4 dígits abans del hash
        $lastFourDigits = substr($validated['numero'], -4);
        // Fer hash del número de targeta i afegir els últims 4 dígits
        $validated['numero'] = Hash::make($validated['numero']) . '_' . $lastFourDigits;

        // Actualitzar el mètode de pagament
        $metodePagament->update($validated);

        // Emmascarar el número en la resposta
        $metodePagament->numero = str_repeat('*', 12) . $lastFourDigits;

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

        // El mètode de pagament no existeix o no pertany a l'usuari
        if (!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no vàlid'], 404);
        }

        // Obtenir el carret no completat de l'usuari
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->first();

        // No hi ha cap carret no completat
        if (!$carrito) {
            return response()->json(['message' => 'No hi ha cap carret actiu'], 404);
        }

        // Actualitzar carret com a completat
        $carrito->completat = true;
        $carrito->metode_pagament_id = $metodePagament->id;

        // Guardar carret
        if (!$carrito->save()) {
            return response()->json(['message' => 'Error al processar el pagament'], 500);
        }

        // Carret guardat correctament
        return response()->json(['message' => 'Pagament processat i comanda completada correctament']);
    }
}
