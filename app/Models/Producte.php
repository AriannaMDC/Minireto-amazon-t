<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producte extends Model
{
    use HasFactory;

    protected $table = 'productes';

    protected $fillable = [
        'nom',
        'descr',
        'valoracio',
        'num_resenyes',
        'preu',
        'enviament',
        'dies',
        'devolucio',
        'devolucioGratis',
        'dataAfegit',
        'stock',
        'categoria_id',
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function caracteristiques() {
        return $this->hasMany(Caracteristica::class);
    }
}
