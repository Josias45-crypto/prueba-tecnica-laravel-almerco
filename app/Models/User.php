<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identificador',
        'name',
        'nombre',
        'email',
        'password',
        'numero_celular',
        'cedula',
        'fecha_nacimiento',
        'city_id',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Relación: Un usuario pertenece a una ciudad
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relación: Un usuario tiene muchos emails
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Accessor: Calcular edad desde fecha de nacimiento
     */
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }
}
