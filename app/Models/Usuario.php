<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';

    // Llave primaria
    protected $primaryKey = 'id';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_user',
        'nombre',
        'segundo_nombre',
        'apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'fecha_ingreso',
        'dpi',
        'igss',
        'telefono',
        'domicilio',
        'estado_civil',
        'conyugue',
        'puesto',
        'departamento',
        'no_cuenta',
        'banco',
        'activo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    
}
