<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación: Un edificio tiene muchas aulas
    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }
}
