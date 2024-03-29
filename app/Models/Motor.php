<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Motor extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id_motor';

   /*  protected function statusId():Attribute
    {
        return new Attribute(
            get: function($value)
            {
                switch ($value)
                {
                    case '-1': return "No Asignados";
                    case '1': return "No Asignados";
                }
            }
        );
    } */
  
    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'id_cliente');
    }
    public function getPotenciaAttribute()
    {
        if ($this->hpkw == 0)
            return $this->hp." Hp";
        else
           return $this->hp." Kw";
    }

    public function getFullOsAttribute()
    {
        return $this->year."-".$this->os;
    }

    public function tecnicos()
    {
        return $this->belongsToMany(User::class,'asignacions','id_motor','id_user');
    }
    public function fotos()
    {
        return $this->hasMany(Foto::class,'id_motor');
    }
    public function contactos()
    {
        return $this->belongsToMany(Contacto::class, 'informar_a_contactos', 'id_motor', 'id_contacto');
    }
    
    
}
