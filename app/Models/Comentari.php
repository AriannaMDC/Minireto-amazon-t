<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producte;
use App\Models\User;

class Comentari extends Model
{
    use HasFactory;

    protected $table = 'comentaris';

    protected $fillable = [
        'valoracio',
        'comentari',
        'imatges',
        'util',
        'model',
        'usuari_id',
        'producte_id'
    ];

    protected $casts = [
        'imatges' => 'array'
    ];

    public function producte()
    {
        return $this->belongsTo(Producte::class, 'producte_id');
    }

    public function usuari()
    {
        return $this->belongsTo(User::class, 'usuari_id');
    }
}
