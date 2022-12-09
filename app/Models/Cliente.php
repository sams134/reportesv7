<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id_cliente';
    protected $withCount = ['motors'];

    public function info_cliente()
    {
        return $this->hasOne(Info_cliente::class,'id_cliente');
    }
    
    public function motors()
    {
        return $this->hasMany(Motor::class,'id_cliente')->orderBy('year', 'desc')->orderBy('os','desc');
    }

    public function contactos()
    {
        return $this->hasMany(Contacto::class,'id_cliente');
    }
}
