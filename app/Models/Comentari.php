<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentari extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producto_id',
        'valoracio',
        'text',
        'img',
        'date',
        'util',
        'model',
    ];

    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function producto() {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
