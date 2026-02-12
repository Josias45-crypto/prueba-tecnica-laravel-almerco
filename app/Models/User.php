<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
            'is_admin' => 'boolean',
        ];
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function getEdadAttribute()
    {
        if ($this->fecha_nacimiento) {
            return \Carbon\Carbon::parse($this->fecha_nacimiento)->age;
        }
        return null;
    }
}
