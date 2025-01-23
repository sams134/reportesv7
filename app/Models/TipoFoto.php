<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoFoto extends Model
{
    use HasFactory;

    protected $table = 'tipo_fotos';

    // Llave primaria
    protected $primaryKey = 'id';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    protected $guarded = [];

    public $timestamps = true;

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'type');
    }
}
