<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceoArt extends Model
{
    use HasFactory;
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'balanceos_arts';

    // Clave primaria
    protected $primaryKey = 'id';

    // Indica si la clave primaria no es auto-incremental (si se necesita cambiar, define `$incrementing = true;`)
    public $incrementing = false;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Indica que no se usarán timestamps (created_at, updated_at)
    public $timestamps = false;

    // Lista de atributos asignables masivamente
    protected $fillable = [
        'id',
        'image'
    ];

     // Relación con Balanceo (un `BalanceoArt` puede estar relacionado con varios `Balanceo`)
     public function balanceos()
     {
         return $this->hasMany(Balanceo::class, 'balanceos_arts_id', 'id');
     }

}
