<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producte;

class Caracteristica extends Model
{
    use HasFactory;

    protected $table = 'caracteristiques';

    protected $fillable = [
        'nom',
        'propietats',
        'img',
        'stock',
        'producte_id',
        'oferta'
    ];

    protected $casts = [
        'propietats' => 'json',
        'img' => 'array'
    ];

    protected function getImgAttribute($value)
    {
        if (is_string($value)) {
            $images = json_decode($value, true);
        } else {
            $images = $value;
        }

        if (empty($images)) {
            return [];
        }

        if (is_array($images) && count($images) === 1 && is_string($images[0]) && $this->isJson($images[0])) {
            $images = json_decode($images[0], true);
        }

        $result = [];
        foreach ((array) $images as $img) {
            $img = str_replace(url(''), '', $img);
            $img = trim($img, '[]"\\');
            $result[] = url($img);
        }
        return $result;
    }

    private function isJson($string) {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function producte() {
        return $this->belongsTo(Producte::class, 'producte_id');
    }
}
