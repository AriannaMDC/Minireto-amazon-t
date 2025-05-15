<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadistiquesProducte;
use App\Models\Producte;

class EstadistiquesProductesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Producte::with('caracteristiques')->get();

        foreach ($products as $product) {
            for ($month = 1; $month <= 5; $month++) {
                if ($product->caracteristiques->count() > 0) {
                    foreach ($product->caracteristiques as $caracteristica) {
                        $sales = rand(1, 20);
                        EstadistiquesProducte::create([
                            'user_id' => $product->vendedor_id,
                            'producte_id' => $product->id,
                            'caracteristica_id' => $caracteristica->id,
                            'total_compres' => $sales,
                            'total_ingresos' => $sales * $product->preu,
                            'month' => $month,
                            'year' => 2025
                        ]);
                    }
                } else {
                    $sales = rand(1, 20);
                    EstadistiquesProducte::create([
                        'user_id' => $product->vendedor_id,
                        'producte_id' => $product->id,
                        'caracteristica_id' => null,
                        'total_compres' => $sales,
                        'total_ingresos' => $sales * $product->preu,
                        'month' => $month,
                        'year' => 2025
                    ]);
                }
            }
        }
    }
}
