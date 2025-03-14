<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RodamientoMarca extends Model
{
    use HasFactory;
    protected $table = 'rodamientos_marcas';
    protected $fillable = [
        'name',
    ];

    /**
     * Relación: Una marca puede tener muchos ajustes.
     */
    public function ajustes()
    {
        return $this->hasMany(\App\Models\MotorAjuste::class, 'rodamiento_marca_id', 'id');
    }
}
