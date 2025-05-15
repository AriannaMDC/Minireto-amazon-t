<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comentari;
use App\Models\Producte;

class ComentarisSeeder extends Seeder
{
    public function run(): void
    {
        $products = Producte::all();

        foreach ($products as $product) {
            Comentari::create([
                'valoracio' => rand(1, 5),
                'comentari' => 'Molt bon producte, compleix les expectatives. La qualitat és bona i el preu és raonable. Recomanable!',
                'imatges' => null,
                'util' => rand(0, 15),
                'model' => 'M',
                'usuari_id' => 6,
                'producte_id' => $product->id
            ]);
        }
    }
}
