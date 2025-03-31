<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producte;

class Valoracio extends Model
{
    use HasFactory;

    protected $table = 'valoracions';

    protected $fillable = [
        'total_comentaris',
        'mitja_valoracions',
        'total_5_estrelles',
        'total_4_estrelles',
        'total_3_estrelles',
        'total_2_estrelles',
        'total_1_estrelles',
    ];

    public function producte()
    {
        return $this->belongsTo(Producte::class, 'producte_id');
    }
}
