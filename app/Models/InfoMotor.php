<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoMotor extends Model
{
    use HasFactory;

    use HasFactory;

    // Tabla asociada
    protected $table = 'info_motors';

    // Llave primaria
    protected $primaryKey = 'id';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar masivamente

    protected $guarded = [];

    public function getEmergenciaAttribute($value)
    {
        switch ($value) {
            case 1:
                return 'Muy Baja';
            case 2:
                return 'Bajo';
            case 3:
                return 'Normal';
            case 4:
                return 'Alto';
            case $value >= 5:
                return 'Muy Alto';
            default:
                return 'Desconocido'; // Si el valor no coincide con ningún caso
        }
    }
    public function getCotizarAttribute($value)
    {
        return $value == 1 ? 'No, Primero Cotizar' : 'Si, Empezar a trabajar';
    }
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }
}
