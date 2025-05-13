<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadistiques extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provincia',
        'total_compres',
        'month',
        'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
