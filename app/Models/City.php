<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['state_id', 'name'];

    /**
     * Relación: Una ciudad pertenece a un estado
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Relación: Una ciudad tiene muchos usuarios
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
