<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MetodePagament;

class MetodePagamentSeeder extends Seeder
{
    public function run(): void
    {
        MetodePagament::create([
            'tipus' => 'visa',
            'titular' => 'Client User',
            'numero' => '****-****-****-5678',
            'caducitat' => '05/27',
            'cvv' => '***',
            'usuari_id' => 6
        ]);
    }
}
