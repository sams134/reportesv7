<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public const NO_ASIGNADO = -1;
    public const NO_AUTORIZADO = 0;
    public const DIAGNOSTICO = 1;
    public const DIAGNOSTICO_PENDIENTE_AUTORIZACION = 2;
    public const AUTORIZADO_PARCIAL = 3;
    public const AUTORIZADO_COMPLETAMENTE = 4;
    public const RETRASADO = 5;
    public const GARANTIA = 6;
    public const EMERGENCIA = 7;
    public const ALTA_EMERGENCIA = 8;
    public const FINALIZADO = 9;
    public const EN_TRASLADO = 10;
    public const ENTREGADO_SIN_REPARACION = 11;
    public const EPF = 12;
    public const ACEPTACION_PENDIENTE_FACTURACION = 13;
    public const FACTURADO_PENDIENTE_PAGO = 14;
    public const PAGADO = 15;


    public function motors()
    {
        return $this->hasMany(Motor::class, 'status_id');
    }
}
