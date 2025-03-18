<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePagament;
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

        $validated['usuari_id'] = Auth::user()->id;

        $metodePagament = MetodePagament::create($validated);

        return response()->json($metodePagament, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $metodePagament = MetodePagament::find($id);

        if (!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no trobat'], 404);
        }

        return response()->json($metodePagament, 200);
    }

    /**
     * Display the specified resource by user ID.
     */
    public function getByUserId(string $usuari_id)
    {
        $metodesPagament = MetodePagament::where('usuari_id', $usuari_id)->get();

        if ($metodesPagament->isEmpty()) {
            return response()->json(['message' => 'No s\'ha trobat cap mètode de pagament per aquest usuari'], 404);
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

        $metodePagament = MetodePagament::find($id);

        if (!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no trobat'], 404);
        }

        $metodePagament->update($validated);

        return response()->json($metodePagament, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metodePagament = MetodePagament::find($id);

        if (!$metodePagament) {
            return response()->json(['message' => 'Mètode de pagament no trobat'], 404);
        }

        $metodePagament->delete();

        return response()->json(['message' => 'Mètode de pagament eliminat correctament'], 200);
    }
}
