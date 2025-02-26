<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Motor extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'motors';

    // Llave primaria
    protected $primaryKey = 'id_motor';

    // Indicar si la llave primaria es auto incrementable
    public $incrementing = true;

    // Tipo de la llave primaria
    protected $keyType = 'int';

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
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
    public function getPotenciaAttribute()
    {
        if ($this->hpkw == 0)
            return $this->hp . " Hp";
        else
            return $this->hp . " Kw";
    }

    public function getFullOsAttribute()
    {
        return $this->year . "-" . $this->os;
    }



    public function tecnicos()
    {
        return $this->belongsToMany(User::class, 'asignacions', 'id_motor', 'id_user')
            ->withPivot('asignado_por', 'responsabilidad')
            ->withTimestamps()
            ->where('userType', User::TECNICO);
    }
    public function ayudantes()
    {
        return $this->belongsToMany(User::class, 'asignacions', 'id_motor', 'id_user')
            ->withPivot('asignado_por', 'responsabilidad')
            ->withTimestamps()
            ->where('userType', User::AYUDANTES);
    }
    public function asignados()
    {
        return $this->belongsToMany(User::class, 'asignacions', 'id_motor', 'id_user')
            ->withPivot('asignado_por', 'responsabilidad')
            ->withTimestamps();
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'id_motor');
    }
    public function contactos()
    {
        return $this->belongsToMany(
            \App\Models\Contacto::class, // Modelo relacionado
            'informar_a_contactos',      // Nombre de la tabla pivot
            'id_motor',                  // Clave foránea en la tabla pivot para este modelo (Motor)
            'id_contacto',               // Clave foránea en la tabla pivot para el modelo relacionado (Contacto)
            'id_motor',                  // Clave primaria en el modelo Motor
            'id'                         // Clave primaria en el modelo Contacto
        )->withTimestamps();
    }
    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'id_motor');
    }
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_motor');
    }
    public function infoMotor()
    {
        return $this->hasOne(InfoMotor::class, 'id_motor');
    }
    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'id_motor');
    }
    public function materialesPedidos()
    {
        return $this->hasMany(MaterialesPedido::class, 'id_motor');
    }
    public function trabajos()
    {
        return $this->hasMany(Trabajo::class, 'id_motor');
    }
    public function tipoEquipo()
    {
        return $this->belongsTo(TipoEquipo::class, 'id_tipoequipo', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function balanceo()
    {
        return $this->hasOne(Balanceo::class, 'motor_id', 'id_motor');
    }
    public function metalizados()
    {
        return $this->hasMany(MotorMetalizado::class, 'id_motor', 'id_motor');
    }
    public function looks()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'looks',        // Tabla pivot
            'motor_id',     // Clave foránea en la tabla pivot para este modelo (Motor)
            'user_id'       // Clave foránea en la tabla pivot para el modelo relacionado (User)
        )->withTimestamps();
    }
    public function envioFinal()
    {
        return $this->hasOne(Envio::class, 'id_motor', 'id_motor')
            ->where('tipo_envio', '1');
    }

    public function enviosParciales()
    {
        return $this->hasMany(Envio::class, 'id_motor', 'id_motor')
            ->where('tipo_envio', '2');
    }
    public function horasExtras()
    {
        return $this->hasMany(HorasExtra::class, 'id_motor', 'id_motor');
    }
    public function totalHorasExtras()
    {
        return $this->horasExtras()->sum('hours');
    }
    public function tipoTrabajo()
    {
        return $this->belongsTo(\App\Models\TipoTrabajo::class, 'id_trabajo', 'id');
    }
    public function pins()
    {
        return $this->morphMany(Pin::class, 'pinable');
    }
}
