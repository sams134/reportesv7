<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorMetalizado extends Model
{
    use HasFactory;

    // Indicamos la tabla correspondiente
    protected $table = 'motors_metalizados';

    // Campos asignables de forma masiva
    protected $fillable = [
        'year',
        'os',
        'diametro',
        'largo',
        'profundidad',
        'id_cliente',
        'id_motor',
    ];

    public $timestamps = true;

    /**
     * Relación con el modelo Cliente.
     * Relaciona el campo id_cliente de esta tabla con el campo id_cliente de la tabla clientes.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Relación con el modelo Motor.
     * Relaciona el campo id_motor de esta tabla con el campo id_motor de la tabla motors.
     */
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }
    public function getFullOsAttribute()
    {
        return $this->year . "-" . $this->os;
    }

    public function images()
    {
        return $this->morphMany(\App\Models\Image::class, 'imageable');
    }
    public function pins()
    {
        return $this->morphMany(Pin::class, 'pinable');
    }
    
}
