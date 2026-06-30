<?php

namespace App\Http\Livewire\Cotizaciones;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ListadoPrecios extends Component
{
    public $tabActiva = 'rebobinados';

    public $rebobinados = [];
    public $mantenimientos = [];
    public $balanceos = [];
    public $encamisados = [];
    public $rodamientosCatalogo = [];
    public $rodamientosPrecios = [];
    public $pruebas = [];

    public function mount()
    {
        abort_unless($this->usuarioPuedeAdministrarPrecios(), 403);

        $this->cargarDatos();
    }

    private function usuarioPuedeAdministrarPrecios(): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        /*
         * Ajusta estos IDs si en tu tabla userType son otros.
         * Aquí asumo:
         * 1 = Developer
         * 2 = Gerencia
         */
        if (isset($user->userType) && is_numeric($user->userType)) {
            return in_array((int) $user->userType, [1, 2]);
        }

        $tipo = strtolower(trim((string) (
            $user->userType
            ?? $user->user_type
            ?? ''
        )));

        return in_array($tipo, ['developer', 'gerencia']);
    }

    public function cargarDatos()
    {
        $this->rebobinados = DB::table('cotizacion_rebobinado_precios')
            ->orderBy('limite_inferior_hp')
            ->orderBy('limite_superior_hp')
            ->orderBy('polos')
            ->orderBy('inverter_duty')
            ->get()
            ->map(fn($row) => (array) $row)
            ->toArray();

        $this->mantenimientos = DB::table('cotizacion_mantenimiento_precios')
            ->orderBy('limite_inferior_hp')
            ->orderBy('limite_superior_hp')
            ->orderBy('polos')
            ->orderBy('voltaje_max')
            ->get()
            ->map(fn($row) => (array) $row)
            ->toArray();

        $this->balanceos = DB::table('cotizacion_balanceo_precios')
            ->orderBy('limite_inferior_hp')
            ->orderBy('limite_superior_hp')
            ->orderBy('polos')
            ->get()
            ->map(fn($row) => (array) $row)
            ->toArray();

        $this->encamisados = DB::table('cotizacion_encamisado_precios')
            ->orderBy('tamanio_minimo')
            ->orderBy('tamanio_maximo')
            ->get()
            ->map(fn($row) => (array) $row)
            ->toArray();

        $this->rodamientosCatalogo = DB::table('cotizacion_rodamientos_catalogo')
            ->orderBy('orden')
            ->orderBy('codigo')
            ->get()
            ->map(fn($row) => (array) $row)
            ->toArray();

        $this->rodamientosPrecios = DB::table('cotizacion_rodamiento_precios')
            ->orderBy('codigo_base')
            ->orderBy('marca')
            ->orderBy('designacion')
            ->get()
            ->map(fn($row) => (array) $row)
            ->toArray();

        $this->pruebas = DB::table('cotizacion_prueba_precios')
            ->orderBy('prueba_tipo')
            ->orderBy('ubicacion')
            ->orderBy('tension_tipo')
            ->orderBy('voltaje')
            ->get()
            ->map(fn($row) => (array) $row)
            ->toArray();
    }

    private function autorizar()
    {
        abort_unless($this->usuarioPuedeAdministrarPrecios(), 403);
    }

    public function guardarRebobinados()
    {
        $this->autorizar();

        foreach ($this->rebobinados as $row) {
            DB::table('cotizacion_rebobinado_precios')
                ->where('id', $row['id'])
                ->update([
                    'precio_aprox' => $row['precio_aprox'] ?? 0,
                    'costo_pruebas_estator' => $row['costo_pruebas_estator'] ?? 0,
                    'costo_trabajos_motor_completo' => $row['costo_trabajos_motor_completo'] ?? 0,
                    'costo_pruebas_motor_completo' => $row['costo_pruebas_motor_completo'] ?? 0,
                    'activo' => !empty($row['activo']) ? 1 : 0,
                    'updated_at' => now(),
                ]);
        }

        $this->avisarGuardado('Precios de rebobinados actualizados.');
    }

    public function guardarMantenimientos()
    {
        $this->autorizar();

        foreach ($this->mantenimientos as $row) {
            DB::table('cotizacion_mantenimiento_precios')
                ->where('id', $row['id'])
                ->update([
                    'precio_aprox' => $row['precio_aprox'] ?? 0,
                    'costo_pruebas_estator' => $row['costo_pruebas_estator'] ?? 0,
                    'costo_trabajos_motor_completo' => $row['costo_trabajos_motor_completo'] ?? 0,
                    'costo_pruebas_motor_completo' => $row['costo_pruebas_motor_completo'] ?? 0,

                    'costo_trabajos_reductora' => $row['costo_trabajos_reductora'] ?? 0,
                    'costo_pruebas_reductora' => $row['costo_pruebas_reductora'] ?? 0,

                    'costo_trabajos_bomba' => $row['costo_trabajos_bomba'] ?? 0,
                    'costo_pruebas_bomba' => $row['costo_pruebas_bomba'] ?? 0,

                    'costo_trabajos_ventilador' => $row['costo_trabajos_ventilador'] ?? 0,
                    'costo_pruebas_ventilador' => $row['costo_pruebas_ventilador'] ?? 0,

                    'costo_trabajos_maquina' => $row['costo_trabajos_maquina'] ?? 0,
                    'costo_pruebas_maquina' => $row['costo_pruebas_maquina'] ?? 0,

                    'activo' => !empty($row['activo']) ? 1 : 0,
                    'updated_at' => now(),
                ]);
        }

        $this->avisarGuardado('Precios de mantenimientos actualizados.');
    }

    public function guardarBalanceos()
    {
        $this->autorizar();

        foreach ($this->balanceos as $row) {
            DB::table('cotizacion_balanceo_precios')
                ->where('id', $row['id'])
                ->update([
                    'precio_aprox' => $row['precio_aprox'] ?? 0,
                    'activo' => !empty($row['activo']) ? 1 : 0,
                    'updated_at' => now(),
                ]);
        }

        $this->avisarGuardado('Precios de balanceos actualizados.');
    }

    public function guardarEncamisados()
    {
        $this->autorizar();

        foreach ($this->encamisados as $row) {
            DB::table('cotizacion_encamisado_precios')
                ->where('id', $row['id'])
                ->update([
                    'precio' => $row['precio'] ?? 0,
                    'activo' => !empty($row['activo']) ? 1 : 0,
                    'updated_at' => now(),
                ]);
        }

        $this->avisarGuardado('Precios de encamisados actualizados.');
    }

    public function guardarRodamientosCatalogo()
    {
        $this->autorizar();

        foreach ($this->rodamientosCatalogo as $row) {
            DB::table('cotizacion_rodamientos_catalogo')
                ->where('id', $row['id'])
                ->update([
                    'diametro_exterior_mm' => $row['diametro_exterior_mm'] ?? 0,
                    'activo' => !empty($row['activo']) ? 1 : 0,
                    'orden' => $row['orden'] ?? 0,
                    'updated_at' => now(),
                ]);
        }

        $this->avisarGuardado('Catálogo de rodamientos actualizado.');
    }

    public function guardarRodamientosPrecios()
    {
        $this->autorizar();

        foreach ($this->rodamientosPrecios as $row) {
            DB::table('cotizacion_rodamiento_precios')
                ->where('id', $row['id'])
                ->update([
                    'designacion' => $row['designacion'] ?? '',
                    'precio' => $row['precio'] ?? 0,
                    'moneda' => $row['moneda'] ?? 'GTQ',
                    'activo' => !empty($row['activo']) ? 1 : 0,
                    'updated_at' => now(),
                ]);
        }

        $this->avisarGuardado('Precios de rodamientos actualizados.');
    }

    public function guardarPruebas()
    {
        $this->autorizar();

        foreach ($this->pruebas as $row) {
            DB::table('cotizacion_prueba_precios')
                ->where('id', $row['id'])
                ->update([
                    'nombre' => $row['nombre'] ?? '',
                    'descripcion' => $row['descripcion'] ?? null,
                    'precio_unitario' => $row['precio_unitario'] ?? 0,
                    'precio_total' => $row['precio_total'] ?? 0,
                    'moneda' => $row['moneda'] ?? 'GTQ',
                    'activo' => !empty($row['activo']) ? 1 : 0,
                    'updated_at' => now(),
                ]);
        }

        $this->avisarGuardado('Precios de pruebas actualizados.');
    }

    private function avisarGuardado($mensaje)
    {
        $this->dispatchBrowserEvent('swal-success', [
            'message' => $mensaje,
        ]);

        $this->cargarDatos();
    }

    public function render()
    {
        return view('livewire.cotizaciones.listado-precios');
    }
}
