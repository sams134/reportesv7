<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    use HasFactory;

    // Nombre de la tabla (por si no sigue el estándar de Laravel)
    protected $table = 'tipo_equipos';

    // Campos que pueden ser asignados masivamente
    protected $fillable = ['name'];

    // Relación con el modelo Motor
    public function motores()
    {
        return $this->hasMany(Motor::class, 'id_tipoequipo', 'id');
    }
}
