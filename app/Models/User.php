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
        'comarca',
        'municipi',
        'provincia',
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

    /**
     * Get the img attribute with full URL path.
     *
     * @param  string  $value
     * @return string
     */
    protected function getImgAttribute($value)
    {
        if (empty($value)) {
            return url('images/users/default.png');
        }

        return url($value);
    }

    public function metodesPagament()
    {
        return $this->hasMany(MetodePagament::class, 'usuari_id');
    }

    public function productes()
    {
        return $this->hasMany(Producte::class, 'vendedor_id');
    }

    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }

    public function comentaris()
    {
        return $this->hasMany(Comentari::class, 'usuari_id');
    }
}
