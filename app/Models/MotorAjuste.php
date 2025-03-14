<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorAjuste extends Model
{
    use HasFactory;

    protected $table = 'motors_ajustes';

    protected $guarded = ['id'];

    /**
     * Relación: Este ajuste pertenece a un Motor.
     */
    public function motor()
    {
        return $this->belongsTo(\App\Models\Motor::class, 'id_motor', 'id_motor');
    }

    /**
     * Relación: Este ajuste pertenece a un Rodamiento.
     */
    public function rodamiento()
    {
        return $this->belongsTo(\App\Models\Rodamiento::class, 'rodamiento_id', 'id');
    }
    public function rodamientoMarca()
    {
        return $this->belongsTo(\App\Models\RodamientoMarca::class, 'rodamiento_marca_id', 'id');
    }
    public function grasa()
    {
        return $this->belongsTo(\App\Models\Grasa::class, 'grasa_id', 'id');
    }
    public function optionTornero()
    {
        return $this->belongsTo(OptionTornero::class, 'options_tornero_id', 'id');
    }
    public function userMedida()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_medida_id', 'id');
    }

    // Relación: Usuario que toma la decisión
    public function userDecision()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_decision_id', 'id');
    }

}
