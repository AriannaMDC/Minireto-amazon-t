<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadistiquesProducte extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producte_id',
        'caracteristica_id',
        'total_compres',
        'month',
        'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
