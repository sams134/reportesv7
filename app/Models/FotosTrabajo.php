<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotosTrabajo extends Model
{
    use HasFactory;

    protected $table = 'fotos_trabajos';

    // Llave primaria
    protected $primaryKey = 'id';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_foto',
        'id_trabajo',
        'progress',
    ];

    // Relación con el modelo Foto
    public function foto()
    {
        return $this->belongsTo(Foto::class, 'id_foto');
    }

    // Relación con el modelo Trabajo
    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class, 'id_trabajo');
    }
    
}
