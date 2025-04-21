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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function linies()
    {
        return $this->hasMany(LiniaCarrito::class);
    }
}
