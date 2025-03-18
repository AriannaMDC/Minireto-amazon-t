<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Caracteristica;
use App\Models\User;

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
        'stock',
        'categoria_id',
        'destacat',
        'vendedor_id'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function caracteristiques() {
        return $this->hasMany(Caracteristica::class, 'producte_id');
    }

    public function vendedor() {
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}
