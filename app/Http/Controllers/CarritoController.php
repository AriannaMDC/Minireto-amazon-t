<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\LiniaCarrito;
use App\Models\Producte;
use App\Models\Caracteristica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->with(['linies.producte', 'linies.caracteristica'])
            ->first();

        if (!$carrito) {
            return response()->json([]);
        }

        return response()->json($this->transformCartResponse($carrito));
    }

    public function addProducte(Request $request)
    {
        $request->validate([
            'producte_id' => 'required|exists:productes,id',
            'caracteristica_id' => 'required|exists:caracteristiques,id',
        ]);

        // Verificar que la caracteristica pertany al producte
        $caracteristica = Caracteristica::where('id', $request->caracteristica_id)
            ->where('producte_id', $request->producte_id)
            ->first();

        if (!$caracteristica) {
            return response()->json(['message' => 'La característica seleccionada no pertany a aquest producte'], 400);
        }

        // Verificar stock disponible
        if ($caracteristica->stock < 1) {
            return response()->json(['message' => 'No hi ha prou stock disponible'], 400);
        }

        // Obtenir o crear carrito
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->first();

        if (!$carrito) {
            $carrito = new Carrito();
            $carrito->user_id = Auth::id();
            $carrito->completat = false;

            if (!$carrito->save()) {
                return response()->json(['message' => 'Error al crear el carrito'], 500);
            }
        }

        // Comprovar si el producte ja està al carrito
        $liniaCarrito = LiniaCarrito::where('carrito_id', $carrito->id)
            ->where('producte_id', $request->producte_id)
            ->where('caracteristica_id', $request->caracteristica_id)
            ->first();

        if ($liniaCarrito) {
            // Verificar si hi ha prou estoc per la nova quantitat total
            if ($caracteristica->stock < ($liniaCarrito->quantitat + 1)) {
                return response()->json(['message' => 'No hi ha prou estoc disponible'], 400);
            }

            $liniaCarrito->quantitat += 1;
            $liniaCarrito->preu_total = $liniaCarrito->quantitat * $liniaCarrito->preu;

            if (!$liniaCarrito->save()) {
                return response()->json(['message' => 'Error al actualitzar la línia del carrito'], 500);
            }

            // Actualitzar stock
            $caracteristica->stock -= 1;
            if (!$caracteristica->save()) {
                return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
            }
        } else {
            $producte = Producte::find($request->producte_id);
            $basePrice = $producte->preu;

            // Apply discount only from the caracteristica's oferta
            if ($caracteristica->oferta > 0) {
                $discountMultiplier = (100 - $caracteristica->oferta) / 100;
                $basePrice = $basePrice * $discountMultiplier;
            }

            $liniaCarrito = new LiniaCarrito();
            $liniaCarrito->carrito_id = $carrito->id;
            $liniaCarrito->producte_id = $request->producte_id;
            $liniaCarrito->caracteristica_id = $request->caracteristica_id;
            $liniaCarrito->quantitat = 1;
            $liniaCarrito->preu = $basePrice;
            $liniaCarrito->preu_total = $basePrice;

            if (!$liniaCarrito->save()) {
                return response()->json(['message' => 'Error al crear la línia del carrito'], 500);
            }

            // Actualitzar stock
            $caracteristica->stock -= 1;
            if (!$caracteristica->save()) {
                return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
            }
        }

        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function incrementQuantitat($liniaId)
    {
        $liniaCarrito = LiniaCarrito::find($liniaId);
        if (!$liniaCarrito) {
            return response()->json(['message' => 'Línia de carrito no trobada'], 404);
        }

        $carrito = $liniaCarrito->carrito;
        if ($carrito->user_id !== Auth::id() || $carrito->completat) {
            return response()->json(['message' => 'No autoritzat'], 403);
        }

        // Verificar stock disponible
        $caracteristica = Caracteristica::find($liniaCarrito->caracteristica_id);
        if (!$caracteristica || $caracteristica->stock < 1) {
            return response()->json(['message' => 'No hi ha prou stock disponible'], 400);
        }

        $liniaCarrito->quantitat += 1;
        $liniaCarrito->preu_total = $liniaCarrito->quantitat * $liniaCarrito->preu;

        if (!$liniaCarrito->save()) {
            return response()->json(['message' => 'Error al actualitzar la línia del carrito'], 500);
        }

        // Actualitzar stock
        $caracteristica->stock -= 1;
        if (!$caracteristica->save()) {
            return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
        }

        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function decrementQuantitat($liniaId)
    {
        $liniaCarrito = LiniaCarrito::find($liniaId);
        if (!$liniaCarrito) {
            return response()->json(['message' => 'Línia de carrito no trobada'], 404);
        }

        $carrito = $liniaCarrito->carrito;
        if ($carrito->user_id !== Auth::id() || $carrito->completat) {
            return response()->json(['message' => 'No autoritzat'], 403);
        }

        // Get caracteristica to update stock
        $caracteristica = Caracteristica::find($liniaCarrito->caracteristica_id);
        if (!$caracteristica) {
            return response()->json(['message' => 'Característica no trobada'], 404);
        }

        if ($liniaCarrito->quantitat <= 1) {
            if (!$liniaCarrito->delete()) {
                return response()->json(['message' => 'Error al eliminar la línia del carrito'], 500);
            }
            // Return stock when removing last item
            $caracteristica->stock += 1;
        } else {
            $liniaCarrito->quantitat -= 1;
            $liniaCarrito->preu_total = $liniaCarrito->quantitat * $liniaCarrito->preu;

            if (!$liniaCarrito->save()) {
                return response()->json(['message' => 'Error al actualitzar la línia del carrito'], 500);
            }
            // Return stock when decreasing quantity
            $caracteristica->stock += 1;
        }

        if (!$caracteristica->save()) {
            return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
        }

        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function removeProducte($liniaId)
    {
        $liniaCarrito = LiniaCarrito::find($liniaId);
        if (!$liniaCarrito) {
            return response()->json(['message' => 'Línia de carrito no trobada'], 404);
        }

        $carrito = $liniaCarrito->carrito;
        if ($carrito->user_id !== Auth::id() || $carrito->completat) {
            return response()->json(['message' => 'No autoritzat'], 403);
        }

        // Get caracteristica to update stock
        $caracteristica = Caracteristica::find($liniaCarrito->caracteristica_id);
        if (!$caracteristica) {
            return response()->json(['message' => 'Característica no trobada'], 404);
        }

        // Return all stock for the removed line
        $caracteristica->stock += $liniaCarrito->quantitat;
        if (!$caracteristica->save()) {
            return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
        }

        if (!$liniaCarrito->delete()) {
            return response()->json(['message' => 'Error al eliminar la línia del carrito'], 500);
        }

        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function buidarCarrito()
    {
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->with('linies.caracteristica')
            ->first();

        if (!$carrito) {
            return response()->json(['message' => 'No hi ha cap carrito actiu'], 404);
        }

        // Return stock for all lines before deleting them
        foreach ($carrito->linies as $linia) {
            $caracteristica = Caracteristica::find($linia->caracteristica_id);
            if ($caracteristica) {
                $caracteristica->stock += $linia->quantitat;
                $caracteristica->save();
            }
        }

        if (!$carrito->linies()->delete()) {
            return response()->json(['message' => 'Error al buidar el carrito'], 500);
        }

        return response()->json([]);
    }

    public function completar()
    {
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->with(['linies.caracteristica', 'linies.producte'])
            ->first();

        if (!$carrito) {
            return response()->json(['message' => 'No hi ha cap carrito actiu'], 404);
        }

        // Verificar i actualitzar stock per cada línia
        foreach ($carrito->linies as $linia) {
            $caracteristica = $linia->caracteristica;
            if (!$caracteristica || $caracteristica->stock < $linia->quantitat) {
                return response()->json([
                    'message' => 'No hi ha prou stock disponible per alguns productes',
                    'producte_id' => $linia->producte_id,
                    'caracteristica_id' => $linia->caracteristica_id
                ], 400);
            }

            // Actualitzar stock
            $caracteristica->stock = $caracteristica->stock - $linia->quantitat;
            if (!$caracteristica->save()) {
                return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
            }
        }

        $carrito->completat = true;
        if (!$carrito->save()) {
            return response()->json(['message' => 'Error al completar el carrito'], 500);
        }

        return response()->json(['message' => 'Comanda completada correctament']);
    }

    private function transformCartResponse($carrito)
    {
        return [
            'user_id' => $carrito->user_id,
            'id' => $carrito->id,
            'lines' => $carrito->linies->map(function ($linia) {
                $imgArray = json_decode($linia->caracteristica->img, true);
                $firstImage = $imgArray ? $imgArray[0] : null;

                return [
                    'id' => $linia->id,
                    'quantitat' => $linia->quantitat,
                    'preu' => $linia->preu,
                    'preu_total' => $linia->preu_total,
                    'producte_id' => $linia->producte->id,
                    'titol' => $linia->producte->nom,
                    'enviament' => $linia->producte->enviament,
                    'dies' => $linia->producte->dies,
                    'model_id' => $linia->caracteristica->id,
                    'nom_model' => $linia->caracteristica->nom,
                    'oferta_model' => $linia->caracteristica->oferta,
                    'imatge' => $firstImage
                ];
            })
        ];
    }
}
