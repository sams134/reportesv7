<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Balanceo extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'balanceos';

    // Clave primaria
    protected $primaryKey = 'id';

    // Indica si la clave primaria es auto-incremental
    public $incrementing = true;

    // Tipo de clave primaria (por si se usa otro tipo de clave)
    protected $keyType = 'int';

    // Indica si las marcas de tiempo (timestamps) están habilitadas
    public $timestamps = true;

    // Lista de atributos que se pueden asignar masivamente
    protected $guarded = [];

    // Relación con el modelo Motor
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'motor_id', 'id_motor');
    }
    public function balanceoSteps()
    {
        return $this->hasMany(BalanceoStep::class , 'balanceo_id', 'id');
    }
    public function balanceoArt()
    {
        return $this->belongsTo(BalanceoArt::class, 'balanceos_arts_id', 'id');
    }
}
