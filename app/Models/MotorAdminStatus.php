<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorAdminStatus extends Model
{
    protected $table = 'motor_admin_statuses';

    protected $guarded = [];

    protected $casts = [
        'cotizacion_fecha' => 'datetime',
        'requerimiento_fecha' => 'datetime',
        'oc_fecha' => 'datetime',
        'autorizacion_fecha' => 'datetime',
        'anticipo_fecha' => 'datetime',
        'aceptacion_fecha' => 'datetime',
        'factura_fecha' => 'datetime',
        'contrasena_pago_fecha' => 'datetime',
        'pago_fecha' => 'datetime',
        'anticipo_monto' => 'decimal:2',
    ];

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function documentos()
    {
        return $this->hasMany(\App\Models\MotorAdminStatusDocument::class, 'motor_admin_status_id', 'id')
            ->latest();
    }
    public function documentosOc()
    {
        return $this->documentos()->where('tipo', 'oc');
    }

    public function documentosFactura()
    {
        return $this->documentos()->where('tipo', 'factura');
    }

    public function documentosContrasenaPago()
    {
        return $this->documentos()->where('tipo', 'contrasena_pago');
    }

    public function documentosPago()
    {
        return $this->documentos()->where('tipo', 'pago');
    }
}
