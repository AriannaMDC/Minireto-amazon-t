<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producte;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $producte1 = Producte::create([
            'nom' => 'Producte 1',
            'descr' => 'Producte descripcio',
            'preu' => 100.50,
            'enviament' => 3.00,
            'dies' => 5,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 1,
            'destacat' => false,
            'vendedor_id' => 1
        ]);

        $producte1->caracteristiques()->create([
            'nom' => 'Model 1',
            'stock' => 100,
            'oferta' => 20,
            'propietats' => json_encode(['color' => 'Negre']),
            'img' => json_encode(['images/products/product_placeholder.jpg'])
        ]);

        $producte2 = Producte::create([
            'nom' => 'Producte 2',
            'descr' => 'Producte descripcio',
            'preu' => 100.50,
            'enviament' => 3.00,
            'dies' => 5,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 1,
            'destacat' => true,
            'vendedor_id' => 1
        ]);

        $producte2->caracteristiques()->createMany([
            [
                'nom' => 'Model 1',
                'stock' => 10,
                'oferta' => 0,
                'propietats' => json_encode(['color' => 'Blau']),
                'img' => json_encode(['images/products/product_placeholder.jpg'])
            ],
            [
                'nom' => 'Model 2',
                'stock' => 50,
                'oferta' => 15,
                'propietats' => json_encode(['color' => 'Roig']),
                'img' => json_encode(['images/products/product_placeholder.jpg'])
            ]
        ]);

        $producte3 = Producte::create([
            'nom' => 'Producte 3',
            'descr' => 'Producte descripcio',
            'preu' => 100.50,
            'enviament' => 3.00,
            'dies' => 5,
            'devolucio' => true,
            'devolucioGratis' => false,
            'categoria_id' => 1,
            'destacat' => true,
            'vendedor_id' => 1
        ]);

        $producte3->caracteristiques()->create([
            'nom' => 'Model 1',
            'stock' => 0,
            'oferta' => 0,
            'propietats' => json_encode(['color' => 'Negre']),
            'img' => json_encode(['images/products/product_placeholder.jpg'])
        ]);
    }
}
