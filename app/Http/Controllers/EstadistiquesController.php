<?php

namespace App\Http\Controllers;

use App\Models\Estadistiques;
use App\Models\EstadistiquesProducte;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EstadistiquesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'checkVendorRole']);
    }

    // Obtenir el total de productes comprats per mes d'aquest any
    public function getProductesPerMonth()
    {
        $year = Carbon::now()->year;
        $stats = EstadistiquesProducte::selectRaw('month, SUM(total_compres) as total')
            ->where('year', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Crear matriu amb tots els mesos (fins i tot aquells amb 0 compres)
        $monthlyStats = array_fill(1, 12, 0);
        foreach ($stats as $stat) {
            $monthlyStats[$stat->month] = $stat->total;
        }

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
        $year = Carbon::now()->year;
        $stats = EstadistiquesProducte::with('producte')
            ->selectRaw('producte_id, SUM(total_compres) as total')
            ->where('year', $year)
            ->groupBy('producte_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return response()->json($stats->map(function ($stat) {
            return [
                'producte' => $stat->producte->nom,
                'total_compres' => $stat->total
            ];
        }));
    }

    // Obtenir estadístiques mensuals per a un producte específic i la distribució dels seus models
    public function getProducteStats($producteId)
    {
        $year = Carbon::now()->year;

        // Obtenir totals mensuals (tots els models combinats)
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

        // Obtenir distribució de models (per al gràfic circular)
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

        return response()->json([
            'monthly_totals' => $monthlyTotals,
            'model_distribution' => $modelStats
        ]);
    }
}
