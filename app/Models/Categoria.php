<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producte;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name', 'img', 'destacat'];

    public function productes() {
        return $this->hasMany(Producte::class);
    }
}
