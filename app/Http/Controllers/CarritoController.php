<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\LiniaCarrito;
use App\Models\Producte;
use App\Models\Caracteristica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        // Obtenir el carrito de l'usuari autenticat no completat
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->with(['linies.producte', 'linies.caracteristica'])
            ->first();

        // No hi ha cap carrito actiu
        if (!$carrito) {
            return response()->json([]);
        }

        // Mostrar carrito
        return response()->json($this->transformCartResponse($carrito));
    }

    public function addProducte(Request $request)
    {
        $request->validate([
            'producte_id' => 'required|exists:productes,id',
            'caracteristica_id' => 'required|exists:caracteristiques,id',
        ]);

        // Verificar que el model pertany al producte
        $caracteristica = Caracteristica::where('id', $request->caracteristica_id)
            ->where('producte_id', $request->producte_id)
            ->first();

        // El model no existeix en el producte
        if (!$caracteristica) {
            return response()->json(['message' => 'La característica seleccionada no pertany a aquest producte'], 400);
        }

        // Verificar stock disponible
        if ($caracteristica->stock < 1) {
            return response()->json(['message' => 'No hi ha prou stock disponible'], 400);
        }

        // Obtenir carrito de l'usuari autenticat no completat
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->first();

        // Si no existeix crear un nou carrito
        if (!$carrito) {
            $carrito = new Carrito();
            $carrito->user_id = Auth::id();
            $carrito->completat = false;

            // Guardar el carrito
            if (!$carrito->save()) {
                return response()->json(['message' => 'Error al crear el carrito'], 500);
            }
        }

        // Comprovar si el producte ja esta al carrito
        $liniaCarrito = LiniaCarrito::where('carrito_id', $carrito->id)
            ->where('caracteristica_id', $request->caracteristica_id)
            ->first();

        // Si el producte ja existeix incrementar la quantitat
        if ($liniaCarrito) {
            // Verificar que hi ha suficient stock del producte
            if ($caracteristica->stock < ($liniaCarrito->quantitat + 1)) {
                return response()->json(['message' => 'No hi ha prou estoc disponible'], 400);
            }

            // Actualitzar la quantitat i el preu total
            $liniaCarrito->quantitat += 1;
            $liniaCarrito->preu_total = $liniaCarrito->quantitat * $liniaCarrito->preu;

            // Guardar carrito
            if (!$liniaCarrito->save()) {
                return response()->json(['message' => 'Error al actualitzar la línia del carrito'], 500);
            }

            // Actualitzar stock
            $caracteristica->stock -= 1;
            if (!$caracteristica->save()) {
                return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
            }
        } else { // El producte no existeix
            $producte = Producte::find($request->producte_id);
            $preuInicial = $producte->preu;

            // Si el model esta en oferta afegir el descompte
            if ($caracteristica->oferta > 0) {
                $discount = (100 - $caracteristica->oferta) / 100;
                $preuInicial = $preuInicial * $discount;
            }

            // Crear linia carrito
            $liniaCarrito = new LiniaCarrito();
            $liniaCarrito->carrito_id = $carrito->id;
            $liniaCarrito->producte_id = $request->producte_id;
            $liniaCarrito->caracteristica_id = $request->caracteristica_id;
            $liniaCarrito->quantitat = 1;
            $liniaCarrito->preu = $preuInicial;
            $liniaCarrito->preu_total = $preuInicial;

            // Guardar linia carrito
            if (!$liniaCarrito->save()) {
                return response()->json(['message' => 'Error al crear la línia del carrito'], 500);
            }

            // Actualitzar stock producte
            $caracteristica->stock -= 1;
            if (!$caracteristica->save()) {
                return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
            }
        }

        // Mostrar carrito actualitzat
        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function incrementQuantitat($liniaId)
    {
        // Validar que la línia existeix
        $liniaCarrito = LiniaCarrito::find($liniaId);
        if (!$liniaCarrito) {
            return response()->json(['message' => 'Línia de carrito no trobada'], 404);
        }

        // Obtenir el carrito i verificar que pertany a l'usuari autenticat
        $carrito = $liniaCarrito->carrito;
        if ($carrito->user_id !== Auth::id() || $carrito->completat) {
            return response()->json(['message' => 'No autoritzat'], 403);
        }

        // Verificar stock producte
        $caracteristica = Caracteristica::find($liniaCarrito->caracteristica_id);
        if (!$caracteristica || $caracteristica->stock < 1) {
            return response()->json(['message' => 'No hi ha prou stock disponible'], 400);
        }

        // Actualitzar quantitat i preu total
        $liniaCarrito->quantitat += 1;
        $liniaCarrito->preu_total = $liniaCarrito->quantitat * $liniaCarrito->preu;

        // Guardar linia carrito
        if (!$liniaCarrito->save()) {
            return response()->json(['message' => 'Error al actualitzar la línia del carrito'], 500);
        }

        // Actualitzar stock producte
        $caracteristica->stock -= 1;
        if (!$caracteristica->save()) {
            return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
        }

        // Mostrar carrito actualitzat
        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function decrementQuantitat($liniaId)
    {
        // Validar que la línia existeix
        $liniaCarrito = LiniaCarrito::find($liniaId);
        if (!$liniaCarrito) {
            return response()->json(['message' => 'Línia de carrito no trobada'], 404);
        }

        // Obtenir el carrito i verificar que pertany a l'usuari autenticat
        $carrito = $liniaCarrito->carrito;
        if ($carrito->user_id !== Auth::id() || $carrito->completat) {
            return response()->json(['message' => 'No autoritzat'], 403);
        }

        // Verificar stock producte
        $caracteristica = Caracteristica::find($liniaCarrito->caracteristica_id);
        if (!$caracteristica) {
            return response()->json(['message' => 'Característica no trobada'], 404);
        }

        // Actualitzar quantitat i preu total
        if ($liniaCarrito->quantitat <= 1) {
            if (!$liniaCarrito->delete()) { // si la quantitat menor a 1 (0) eliminar producte
                return response()->json(['message' => 'Error al eliminar la línia del carrito'], 500);
            }

            // Retornar stock producte
            $caracteristica->stock += 1;
        } else {
            // Actualizar quantitat i preu total
            $liniaCarrito->quantitat -= 1;
            $liniaCarrito->preu_total = $liniaCarrito->quantitat * $liniaCarrito->preu;

            // Guardar linia carrito
            if (!$liniaCarrito->save()) {
                return response()->json(['message' => 'Error al actualitzar la línia del carrito'], 500);
            }

            // Retornar stock producte
            $caracteristica->stock += 1;
        }

        // Guardar stock producte
        if (!$caracteristica->save()) {
            return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
        }

        // Mostrar carrito actualitzat
        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function removeProducte($liniaId)
    {
        // Validar que la línia existeix
        $liniaCarrito = LiniaCarrito::find($liniaId);
        if (!$liniaCarrito) {
            return response()->json(['message' => 'Línia de carrito no trobada'], 404);
        }

        // Obtenir el carrito i verificar que pertany a l'usuari autenticat
        $carrito = $liniaCarrito->carrito;
        if ($carrito->user_id !== Auth::id() || $carrito->completat) {
            return response()->json(['message' => 'No autoritzat'], 403);
        }

        // Verificar stock producte
        $caracteristica = Caracteristica::find($liniaCarrito->caracteristica_id);
        if (!$caracteristica) {
            return response()->json(['message' => 'Característica no trobada'], 404);
        }

        // Actualitzar stock producte
        $caracteristica->stock += $liniaCarrito->quantitat;
        if (!$caracteristica->save()) {
            return response()->json(['message' => 'Error al actualitzar l\'stock'], 500);
        }

        // Eliminar línia del carrito
        if (!$liniaCarrito->delete()) {
            return response()->json(['message' => 'Error al eliminar la línia del carrito'], 500);
        }

        // Mostrar carrito actualitzat
        $carrito->load(['linies.producte', 'linies.caracteristica']);
        return response()->json($this->transformCartResponse($carrito));
    }

    public function buidarCarrito()
    {
        // Obtenir el carrito de l'usuari autenticat no completat
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->with('linies.caracteristica')
            ->first();

        // No hi ha cap carrito actiu
        if (!$carrito) {
            return response()->json(['message' => 'No hi ha cap carrito actiu'], 404);
        }

        // Retornar stock producte per cada linia del carrito
        foreach ($carrito->linies as $linia) {
            $caracteristica = Caracteristica::find($linia->caracteristica_id);
            if ($caracteristica) {
                $caracteristica->stock += $linia->quantitat;
                $caracteristica->save();
            }
        }

        // Eliminar tot el carrito
        if (!$carrito->linies()->delete()) {
            return response()->json(['message' => 'Error al buidar el carrito'], 500);
        }

        return response()->json([]);
    }

    public function completar()
    {
        // Obtenir el carrito de l'usuari autenticat no completat
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('completat', false)
            ->first();

        // No hi ha cap carrito actiu
        if (!$carrito) {
            return response()->json(['message' => 'No hi ha cap carrito actiu'], 404);
        }

        // Modificar el carrito com a completat i guardar
        $carrito->completat = true;
        if (!$carrito->save()) {
            return response()->json(['message' => 'Error al completar el carrito'], 500);
        }

        return response()->json(['message' => 'Comanda completada correctament']);
    }

    private function transformCartResponse($carrito)
    {
        // Modificar dades que es mostren del carrito
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
