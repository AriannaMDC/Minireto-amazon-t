<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Valoracio;
use App\Models\Producte;

class ValoracionsSeeder extends Seeder
{
    public function run(): void
    {
        $products = Producte::all();

        foreach ($products as $product) {
            $total_5 = rand(10, 30);
            $total_4 = rand(8, 25);
            $total_3 = rand(5, 15);
            $total_2 = rand(2, 8);
            $total_1 = rand(0, 5);

            $total_comentaris = $total_5 + $total_4 + $total_3 + $total_2 + $total_1;
            $mitja_valoracions = (($total_5 * 5) + ($total_4 * 4) + ($total_3 * 3) + ($total_2 * 2) + ($total_1 * 1)) / $total_comentaris;

            Valoracio::create([
                'total_comentaris' => $total_comentaris,
                'mitja_valoracions' => number_format($mitja_valoracions, 1),
                'total_5_estrelles' => $total_5,
                'total_4_estrelles' => $total_4,
                'total_3_estrelles' => $total_3,
                'total_2_estrelles' => $total_2,
                'total_1_estrelles' => $total_1,
                'producte_id' => $product->id
            ]);
        }
    }
}
