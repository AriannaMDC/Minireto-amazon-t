<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MetodePagament extends Model
{
    use HasFactory;

    protected $table = 'metode_pagament';

    protected $fillable = [
        'tipus',
        'titular',
        'numero',
        'caducitat',
        'cvv',
        'usuari_id',
    ];

    protected $hidden = [
        'cvv',
    ];

    public function usuari()
    {
        return $this->belongsTo(User::class, 'usuari_id');
    }
}
