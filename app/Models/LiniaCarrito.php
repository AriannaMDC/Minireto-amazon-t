<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiniaCarrito extends Model
{
    use HasFactory;

    protected $table = 'linia_carritos';

    protected $fillable = [
        'carrito_id',
        'producte_id',
        'caracteristica_id',
        'quantitat',
        'preu',
        'preu_total'
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }

    public function producte()
    {
        return $this->belongsTo(Producte::class);
    }

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class);
    }
}
