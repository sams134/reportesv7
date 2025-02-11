<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $withCount = ['motors'];
    protected $table = 'clientes';

    // Llave primaria
    protected $primaryKey = 'id_cliente';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

    public function info_cliente()
    {
        return $this->hasOne(Info_cliente::class, 'id_cliente', 'id_cliente');
    }

    public function motors()
    {
        return $this->hasMany(Motor::class, 'id_cliente','id_cliente')->orderBy('year', 'desc')->orderBy('os', 'desc');
    }

    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'id_cliente', 'id_cliente');
    }
    public function metalizados()
    {
        return $this->hasMany(MotorMetalizado::class, 'id_cliente', 'id_cliente');
    }
}
