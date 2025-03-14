<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    use HasFactory;

    protected $table = 'pruebas';

    protected $fillable = ['name'];

    /**
     * Relación: Una Prueba puede estar asociada a muchos registros de pruebas_motors.
     */
    public function pruebasMotors()
    {
        return $this->hasMany(PruebaMotor::class, 'id_prueba', 'id');
    }
}
