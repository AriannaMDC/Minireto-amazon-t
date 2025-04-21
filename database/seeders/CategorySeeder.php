<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'name' => 'categoria1',
            'img' => 'images/categories/category_placeholder.jpg',
            'destacat' => false
        ]);

        Categoria::create([
            'name' => 'categoria2',
            'img' => 'images/categories/category_placeholder.jpg',
            'destacat' => true
        ]);

        Categoria::create([
            'name' => 'categoria3',
            'img' => 'images/categories/category_placeholder.jpg',
            'destacat' => true
        ]);

        Categoria::create([
            'name' => 'categoria4',
            'img' => 'images/categories/category_placeholder.jpg',
            'destacat' => true
        ]);
    }
}
