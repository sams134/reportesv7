<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionRebobinadoPrecio extends Model
{
    protected $table = 'cotizacion_rebobinado_precios';

    protected $fillable = [
        'limite_inferior_hp',
        'limite_superior_hp',
        'polos',
        'libras_alambre',
        'inverter_duty',
        'precio_aprox',
        'activo',
        'costo_pruebas_estator',

        'costo_trabajos_motor_completo',
        'costo_pruebas_motor_completo',

        'costo_trabajos_reductora',
        'costo_pruebas_reductora',

        'costo_trabajos_bomba',
        'costo_pruebas_bomba',

        'costo_trabajos_ventilador',
        'costo_pruebas_ventilador',

        'costo_trabajos_maquina',
        'costo_pruebas_maquina',
    ];

    protected $casts = [
        'limite_inferior_hp' => 'decimal:2',
        'limite_superior_hp' => 'decimal:2',
        'libras_alambre' => 'decimal:2',
        'precio_aprox' => 'decimal:2',
        'inverter_duty' => 'boolean',
        'activo' => 'boolean',
        'costo_pruebas_estator' => 'decimal:2',

        'costo_trabajos_motor_completo' => 'decimal:2',
        'costo_pruebas_motor_completo' => 'decimal:2',

        'costo_trabajos_reductora' => 'decimal:2',
        'costo_pruebas_reductora' => 'decimal:2',

        'costo_trabajos_bomba' => 'decimal:2',
        'costo_pruebas_bomba' => 'decimal:2',

        'costo_trabajos_ventilador' => 'decimal:2',
        'costo_pruebas_ventilador' => 'decimal:2',

        'costo_trabajos_maquina' => 'decimal:2',
        'costo_pruebas_maquina' => 'decimal:2',
    ];

    public function scopeBuscarPrecio($query, $hp, $polos, $inverterDuty)
    {
        return $query->where('activo', 1)
            ->where('limite_inferior_hp', '<=', $hp)
            ->where('limite_superior_hp', '>=', $hp)
            ->where('polos', $polos)
            ->where('inverter_duty', $inverterDuty ? 1 : 0);
    }
}
