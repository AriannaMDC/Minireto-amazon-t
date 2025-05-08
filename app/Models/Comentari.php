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

    protected function getImatgesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // If $value is already an array (due to the cast), use it directly
        // otherwise decode it from JSON string
        $images = is_array($value) ? $value : json_decode($value, true);

        if (!is_array($images)) {
            return [];
        }

        return array_map(function($path) {
            return url($path);
        }, $images);
    }

    public function producte()
    {
        return $this->belongsTo(Producte::class, 'producte_id');
    }

    public function usuari()
    {
        return $this->belongsTo(User::class, 'usuari_id');
    }
}
