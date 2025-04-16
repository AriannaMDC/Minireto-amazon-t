<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'completat'
    ];

    // Relació amb l'usuari (pertany a un usuari)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relació amb les línies del carrito (té moltes línies)
    public function linies()
    {
        return $this->hasMany(LiniaCarrito::class);
    }
}
