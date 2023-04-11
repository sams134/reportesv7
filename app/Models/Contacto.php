<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'id_cliente');
    }
    public function motors()
    {
        return $this->belongsToMany(Motor::class, 'informar_a_contactos', 'id_contacto', 'id_motor');
    }

}
