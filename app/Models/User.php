<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\MetodePagament;
use App\Models\Producte;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuari',
        'nom',
        'email',
        'password',
        'password_confirmation',
        'img',
        'rol',
        'direccio',
        'receive_info'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'password_confirmation',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'receive_info' => 'boolean'
    ];

    // Relació amb els mètodes de pagament
    public function metodesPagament()
    {
        return $this->hasMany(MetodePagament::class, 'usuari_id');
    }

    // Relació amb els productes (com a venedor)
    public function productes()
    {
        return $this->hasMany(Producte::class, 'vendedor_id');
    }

    // Relació amb els carritos
    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }

    // Relació amb els comentaris
    public function comentaris()
    {
        return $this->hasMany(Comentari::class, 'usuari_id');
    }
}
