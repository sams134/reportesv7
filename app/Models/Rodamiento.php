<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rodamiento extends Model
{
    use HasFactory;
    protected $table = 'rodamientos';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'designacion',
        'diametro_interno',
        'diametro_externo',
        'ancho',
        'diametro_resalte',
        'diametro_rebaje',
        'chaflan',
    ];
    public function ajustes()
    {
        return $this->hasMany(\App\Models\MotorAjuste::class, 'rodamiento_id', 'id');
    }
}
