<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producte;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'img',
        'destacat'
    ];

    protected function getImgAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        $value = str_replace(url(''), '', $value);
        $value = trim($value, '[]"\\');

        return url($value);
    }

    public function productes() {
        return $this->hasMany(Producte::class);
    }
}
