<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'edificio_id'];

    // Relación: Un aula pertenece a un edificio
    public function edificio()
    {
        return $this->belongsTo(Edificio::class);
    }
}
