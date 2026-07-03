<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CotizacionContacto;
use App\Models\CotizacionItem;
use App\Models\CotizacionUnificadaDetalle;
use App\Models\CotizacionPdfAdjunto;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $fillable = [
        'numero',
        'titulo',
        'subtitulo',
        'cot_year',
        'correlativo',
        'letra',
        'version',

        'id_cliente',
        'id_motor',
        'equipo_no_ingresado_taller',
        'fecha_cotizacion',
        'fecha_valida_hasta',
        'presentacion_id',
        'texto_presentacion',
        'usar_datos_equipo',
        'resumen_equipo',
        'moneda',
        'subtotal',
        'descuento',
        'total',
        'estado',
        'creado_por',
        'tipo_cambio',
        'no_incluye',
        'tiempo_entrega',
        'tiempo_entrega_otro',
        'garantia_modo',
        'garantia_general_activa',
        'garantia_general_tiempo',
        'garantia_electrica_tiempo',
        'garantia_mecanica_tiempo',
        'incluir_terminos_garantias',
        'terminos_pago',
        'cliente_debe_proveer_oc',
        'notas_adicionales',
        'tipo_cotizacion',
        'es_unificada',
        'foto_portada',
    ];

    protected $casts = [
        'equipo_no_ingresado_taller' => 'boolean',
        'usar_datos_equipo' => 'boolean',
        'fecha_cotizacion' => 'date',
        'fecha_valida_hasta' => 'date',
        'no_incluye' => 'array',

        'garantia_general_activa' => 'boolean',
        'incluir_terminos_garantias' => 'boolean',
        'cliente_debe_proveer_oc' => 'boolean',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
        'cot_year' => 'integer',
        'correlativo' => 'integer',
        'version' => 'integer',
        'tipo_cambio' => 'decimal:4',
        'es_unificada' => 'boolean',

    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor', 'id_motor');
    }

    public function contactos()
    {
        return $this->hasMany(CotizacionContacto::class, 'cotizacion_id');
    }

    public function items()
    {
        return $this->hasMany(CotizacionItem::class, 'cotizacion_id')
            ->orderBy('orden');
    }

    public function presentacion()
    {
        return $this->belongsTo(CotizacionTextoPresentacion::class, 'presentacion_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
    public function creadoPor()
    {
        return $this->belongsTo(\App\Models\User::class, 'creado_por', 'id');
    }
    public function contactosCotizacion()
    {
        return $this->hasMany(CotizacionContacto::class, 'cotizacion_id', 'id');
    }
    public function itemsCotizacion()
    {
        return $this->hasMany(CotizacionItem::class, 'cotizacion_id', 'id')
            ->orderBy('orden');
    }
    public function unificadaDetalles()
    {
        return $this->hasMany(CotizacionUnificadaDetalle::class, 'cotizacion_unificada_id', 'id')
            ->orderBy('orden');
    }

    public function perteneceAUnificadas()
    {
        return $this->hasMany(CotizacionUnificadaDetalle::class, 'cotizacion_origen_id', 'id');
    }
    public function pdfsAdjuntos()
    {
        return $this->hasMany(CotizacionPdfAdjunto::class, 'cotizacion_id', 'id')
            ->orderBy('seccion')
            ->orderBy('orden');
    }

    public function pdfsAntesItems()
    {
        return $this->hasMany(CotizacionPdfAdjunto::class, 'cotizacion_id', 'id')
            ->where('seccion', 'antes_items')
            ->orderBy('orden');
    }

    public function pdfsDespuesItems()
    {
        return $this->hasMany(CotizacionPdfAdjunto::class, 'cotizacion_id', 'id')
            ->where('seccion', 'despues_items')
            ->orderBy('orden');
    }
}
