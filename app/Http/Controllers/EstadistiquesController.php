<?php

namespace App\Http\Controllers;

use App\Models\Estadistiques;
use App\Models\EstadistiquesProducte;
use Carbon\Carbon;
use App\Models\Caracteristica;
use Illuminate\Support\Facades\Auth;

class EstadistiquesController extends Controller
{
    // Obtenir el total de productes comprats per mes d'aquest any
    public function getProductesPerMonth()
    {
        $year = Carbon::now()->year;
        $stats = EstadistiquesProducte::selectRaw('month, SUM(total_compres) as total')
            ->where('year', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Crear matriu amb tots els mesos (fins i tot aquells amb 0 compres)
        $monthlyStats = array_replace(
            array_fill(1, 12, 0),
            $stats
        );

        return response()->json($monthlyStats);
    }

    // Obtenir compres per província del mes actual
    public function getCompresPerProvincia()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $stats = Estadistiques::where('year', $year)
            ->where('month', $month)
            ->get()
            ->groupBy('provincia')
            ->map(function ($group) {
                return $group->sum('total_compres');
            });

        return response()->json($stats);
    }

    // Obtenir els 5 productes més comprats
    public function getTop5Productes()
    {
        $user = Auth::user();
        $year = Carbon::now()->year;
        $stats = EstadistiquesProducte::with('producte')
            ->selectRaw('producte_id, SUM(total_compres) as total_compres, SUM(total_ingresos) as total_ingresos')
            ->where('year', $year)
            ->where('user_id', $user->id)  // Filter by authenticated vendor
            ->groupBy('producte_id')
            ->orderByDesc('total_compres')
            ->limit(5)
            ->get();

        return response()->json($stats->map(function ($stat) {
            return [
                'producte' => $stat->producte->nom,
                'total_compres' => $stat->total_compres,
                'total_ingresos' => $stat->total_ingresos
            ];
        }));
    }

    // Obtenir estadístiques mensuals per a un producte específic i la distribució dels seus models
    public function getProducteStats($producteId)
    {
        $year = Carbon::now()->year;

        // Obtenir totals mensuals (tots els models combinats)
        // Get monthly sales totals
        $monthlyStats = EstadistiquesProducte::selectRaw('month, SUM(total_compres) as total')
            ->where('producte_id', $producteId)
            ->where('year', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Omplir els mesos que falten amb 0
        $monthlyTotals = array_replace(
            array_fill(1, 12, 0),
            $monthlyStats
        );

        // Get model distribution
        $modelStats = EstadistiquesProducte::with('caracteristica')
            ->where('producte_id', $producteId)
            ->where('year', $year)
            ->selectRaw('caracteristica_id, SUM(total_compres) as total')
            ->groupBy('caracteristica_id')
            ->get()
            ->map(function ($stat) {
                return [
                    'model' => $stat->caracteristica->nom,
                    'total' => $stat->total,
                ];
            });

        // Get total units and income
        $totals = EstadistiquesProducte::where('producte_id', $producteId)
            ->where('year', $year)
            ->selectRaw('SUM(total_compres) as total_unitats, SUM(total_ingresos) as total_ingresos')
            ->first();

        // Get the product image
        $firstImage = null;
        $caracteristica = Caracteristica::where('producte_id', $producteId)->first();
        if ($caracteristica && !empty($caracteristica->img)) {
            $firstImage = $caracteristica->img[0];
        }

        return response()->json([
            'monthly_totals' => $monthlyTotals,
            'model_distribution' => $modelStats,
            'total_unitats' => $totals->total_unitats ?? 0,
            'total_ingresos' => $totals->total_ingresos ?? 0,
            'imatge' => $firstImage
        ]);
    }
}
