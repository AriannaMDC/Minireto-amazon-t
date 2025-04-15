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
        'preu',
        'enviament',
        'dies',
        'devolucio',
        'devolucioGratis',
        'dataAfegit',
        'oferta',
        'destacat',
        'categoria_id',
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

    public function liniesCarrito()
    {
        return $this->hasMany(LiniaCarrito::class);
    }

    public function comentaris()
    {
        return $this->hasMany(Comentari::class);
    }

    public function valoracio()
    {
        return $this->hasOne(Valoracio::class);
    }
}
