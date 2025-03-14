<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebaMotor extends Model
{
    use HasFactory;

    protected $table = 'pruebas_motors';

    protected $guarded = ['id'];

    /**
     * Relación: Este registro pertenece a una Prueba.
     */
    public function prueba()
    {
        return $this->belongsTo(Prueba::class, 'id_prueba', 'id');
    }

    /**
     * Relación: Este registro pertenece a un Motor.
     */
    public function motor()
    {
        return $this->belongsTo(\App\Models\Motor::class, 'id_motor', 'id_motor');
    }
}
