<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estadistiques;
use App\Models\User;

class EstadistiquesSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = User::where('rol', 'vendedor')->get();
        $provinces = ['Barcelona', 'Tarragona', 'Lleida', 'Girona'];

        foreach ($vendors as $vendor) {
            for ($month = 1; $month <= 5; $month++) {
                foreach ($provinces as $province) {
                    $multiplier = ($province === 'Barcelona') ? 2 : 1;
                    $monthMultiplier = 1 + ($month * 0.1);

                    Estadistiques::create([
                        'user_id' => $vendor->id,
                        'provincia' => $province,
                        'total_compres' => round(rand(5, 20) * $multiplier * $monthMultiplier),
                        'month' => $month,
                        'year' => 2025
                    ]);
                }
            }
        }
    }
}
