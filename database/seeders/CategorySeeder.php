<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Categoria::create([
            'name' => 'Informàtica',
            'img' => '',
            'destacat' => false
        ]);

        Categoria::create([
            'name' => 'Llar',
            'img' => 'images/categories/categoriallar.png',
            'destacat' => true
        ]);

        Categoria::create([
            'name' => 'Roba',
            'img' => '',
            'destacat' => false
        ]);

        Categoria::create([
            'name' => 'Carnestoltes',
            'img' => 'images/categories/categoriacarnestoltes.png',
            'destacat' => true
        ]);
    }
}
