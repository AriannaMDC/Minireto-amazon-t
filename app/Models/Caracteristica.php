<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producte;

class Caracteristica extends Model
{
    use HasFactory;

    protected $table = 'caracteristiques';

    protected $fillable = [
        'nom',
        'propietats',
        'img',
        'stock',
        'producte_id'
    ];

    protected $casts = [
        'propietats' => 'array',
        'img' => 'array'
    ];

    public function producte() {
        return $this->belongsTo(Producte::class, 'producte_id');
    }
}
