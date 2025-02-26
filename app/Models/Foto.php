<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'fotos';

    // Llave primaria
    protected $primaryKey = 'id';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    public const NAMEPLATE = 13;
    PUBLIC CONST INVENTORY = 12;
    PUBLIC CONST MOTOR = 2;
    public const TRABAJO = 3;
    public const FIN = 100;


    // Relación con el modelo Motor
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }

    // Relación con el modelo TipoFoto
    public function tipoFoto()
    {
        return $this->belongsTo(TipoFoto::class, 'type');
    }

    public function fotosTrabajo()
    {
        return $this->hasMany(FotosTrabajo::class, 'id_foto');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
}
