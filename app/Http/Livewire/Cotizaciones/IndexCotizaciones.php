<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\Cotizacion;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\MotorAdminStatus;
use App\Models\MotorAdminStatusDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Http\Livewire\Traits\HandlesMotorAdminStatus;


use App\Models\CotizacionItem;
use App\Models\CotizacionContacto;
use App\Models\CotizacionPdfAdjunto;
use App\Models\CotizacionUnificadaDetalle;



class IndexCotizaciones extends Component
{
    use WithPagination;
    use WithFileUploads;
    use HandlesMotorAdminStatus;

    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';
    public $versionesAbiertas = [];
    public $cotizacionesSeleccionadas = [];

    public $selectedCotizacionId;
    public $selectedMotorId;
    public $adminStatusId;

    public $requerimiento_estado;
    public $requerimiento_numero;

    public $oc_estado;
    public $oc_numero;

    public $autorizacion_estado;
    public $autorizacion_comentario;

    public $anticipo_estado;
    public $anticipo_monto;

    public $aceptacion_estado;
    public $aceptacion_numero;

    public $factura_estado;
    public $factura_numero;

    public $contrasena_pago_estado;
    public $contrasena_pago_numero;

    public $pago_estado;

    public $comentarios;

    public $infoTipo;
    public $infoTitulo;
    public $infoFile;
    public $infoPastedImageData;
    public $infoComentario;
    public $infoDocumentos = [];
    public $cotizacion_estado;

    public $adminDocumentosResumen = [];


    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'eliminarVersionCotizacionConfirmada' => 'eliminarVersionCotizacion',
    ];

    public function mount()
    {
        $user = auth()->user();

        if (!in_array($user->userType, [
            User::DEVELOPER,
            User::GERENCIA,
            User::ADMINISTRACION,
            User::VENDEDORES,
        ])) {
            return redirect()->route('dashboard');
        }
    }

    public function render()
    {
        $cotizaciones = Cotizacion::with([
            'cliente',
            'motor',
            'motor.infoMotor',
            'motor.adminStatus.documentos.uploadedBy',
        ])
            ->where('letra', 'A')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('cotizaciones')
                    ->groupBy('cot_year', 'correlativo', 'letra');
            });

        $this->aplicarBusquedaInteligente($cotizaciones);

        $cotizaciones = $cotizaciones
            ->orderBy($this->sort, $this->direction)
            ->paginate(15);

        return view('livewire.cotizaciones.index-cotizaciones', [
            'cotizaciones' => $cotizaciones,
        ]);
    }
    public function updatedSearch()
    {
        $this->resetPage();
        $this->cotizacionesSeleccionadas = [];
    }
    private function aplicarBusquedaInteligente($query)
    {
        $search = trim((string) $this->search);

        if ($search === '') {
            return $query;
        }

        $searchCompact = strtoupper(preg_replace('/\s+/', '', $search));

        /*
     * Caso 1:
     * COT26-0030, COT-26-0030, cot26-30
     * Buscar SOLO cotización.
     */
        if (preg_match('/^COT-?(\d{2})-?0*(\d{1,4})$/i', $searchCompact, $matches)) {
            $year2 = $matches[1];
            $correlativo = $this->normalizarCorrelativo4($matches[2]);

            return $query->where(function ($q) use ($year2, $correlativo) {
                $this->whereCotizacionExacta($q, $year2, $correlativo);
            });
        }

        /*
     * Caso 2:
     * 2M25-0030, 2m25-30
     * Buscar SOLO OS.
     */
        if (preg_match('/^2M(\d{2})-?0*(\d{1,4})$/i', $searchCompact, $matches)) {
            $year2 = $matches[1];
            $os = $this->normalizarCorrelativo4($matches[2]);

            return $query->where(function ($q) use ($year2, $os) {
                $this->whereOsExacta($q, $year2, $os);
            });
        }

        /*
     * Caso 3:
     * 26-030, 26-30, 25-0030
     * Buscar COT26-0030 y OS 2M26-0030.
     */
        if (preg_match('/^(\d{2})-0*(\d{1,4})$/', $searchCompact, $matches)) {
            $year2 = $matches[1];
            $correlativo = $this->normalizarCorrelativo4($matches[2]);

            return $query->where(function ($q) use ($year2, $correlativo) {
                $this->whereCotizacionExacta($q, $year2, $correlativo);
                $this->orWhereOsExacta($q, $year2, $correlativo);
            });
        }

        /*
     * Caso 4:
     * 30
     * Buscar cualquier COTxx-0030 y cualquier OS 2Mxx-0030.
     */
        if (preg_match('/^\d{1,4}$/', $searchCompact)) {
            $correlativo = $this->normalizarCorrelativo4($searchCompact);
            $correlativoInt = (int) $correlativo;

            return $query->where(function ($q) use ($correlativo, $correlativoInt) {
                $q->where('correlativo', $correlativoInt)
                    ->orWhere('numero', 'like', 'COT__-' . $correlativo . '%')
                    ->orWhereHas('motor', function ($motor) use ($correlativo, $correlativoInt) {
                        $motor->where(function ($m) use ($correlativo, $correlativoInt) {
                            $m->where('os', $correlativo)
                                ->orWhere('os', (string) $correlativoInt)
                                ->orWhereRaw('LPAD(os, 4, "0") = ?', [$correlativo]);
                        });
                    });
            });
        }

        /*
     * Caso 5:
     * Texto general: Cem, Progreso, Ultracem, etc.
     */
        return $query->where(function ($q) use ($search) {
            $q->where('numero', 'like', '%' . $search . '%')
                ->orWhere('titulo', 'like', '%' . $search . '%')
                ->orWhere('subtitulo', 'like', '%' . $search . '%')

                /*
         * Cliente de la cotización.
         * Aquí debe encontrar: Cementos San Gabriel, Cementos Progreso, Ultracem, etc.
         */
                ->orWhereHas('cliente', function ($cliente) use ($search) {
                    $cliente->where('cliente', 'like', '%' . $search . '%');
                })

                /*
         * OS / motor.
         * No usamos potencia aquí porque esa columna no existe en la tabla del motor.
         */
                ->orWhereHas('motor', function ($motor) use ($search) {
                    $motor->where('year', 'like', '%' . $search . '%')
                        ->orWhere('os', 'like', '%' . $search . '%')
                        ->orWhereRaw('CONCAT(year, "-", os) LIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw('CONCAT(year, "-", LPAD(os, 4, "0")) LIKE ?', ['%' . $search . '%']);
                });
        });
    }
    private function normalizarCorrelativo4($value)
    {
        return str_pad((int) $value, 4, '0', STR_PAD_LEFT);
    }

    private function yearCompletoDesde2Digitos($year2)
    {
        return 2000 + (int) $year2;
    }
    private function whereCotizacionExacta($query, $year2, $correlativo4)
    {
        $yearCompleto = $this->yearCompletoDesde2Digitos($year2);
        $correlativoInt = (int) $correlativo4;

        $query->where(function ($q) use ($year2, $yearCompleto, $correlativo4, $correlativoInt) {
            $q->where('numero', 'like', 'COT' . $year2 . '-' . $correlativo4 . '%')
                ->orWhere('numero', 'like', 'COT-' . $year2 . '-' . $correlativo4 . '%')
                ->orWhere(function ($sub) use ($yearCompleto, $year2, $correlativoInt) {
                    $sub->where(function ($yearQuery) use ($yearCompleto, $year2) {
                        $yearQuery->where('cot_year', $yearCompleto)
                            ->orWhere('cot_year', $year2);
                    })
                        ->where('correlativo', $correlativoInt);
                });
        });
    }

    private function whereOsExacta($query, $year2, $os4)
    {
        $yearOs = '2M' . $year2;
        $osInt = (int) $os4;

        $query->whereHas('motor', function ($motor) use ($yearOs, $os4, $osInt) {
            $motor->where(function ($m) use ($yearOs, $os4, $osInt) {
                $m->where(function ($x) use ($yearOs, $os4, $osInt) {
                    $x->where('year', $yearOs)
                        ->where(function ($osQuery) use ($os4, $osInt) {
                            $osQuery->where('os', $os4)
                                ->orWhere('os', (string) $osInt)
                                ->orWhereRaw('LPAD(os, 4, "0") = ?', [$os4]);
                        });
                })
                    ->orWhereRaw('UPPER(CONCAT(year, "-", LPAD(os, 4, "0"))) = ?', [
                        strtoupper($yearOs . '-' . $os4),
                    ]);
            });
        });
    }

    private function orWhereOsExacta($query, $year2, $os4)
    {
        $yearOs = '2M' . $year2;
        $osInt = (int) $os4;

        $query->orWhereHas('motor', function ($motor) use ($yearOs, $os4, $osInt) {
            $motor->where(function ($m) use ($yearOs, $os4, $osInt) {
                $m->where(function ($x) use ($yearOs, $os4, $osInt) {
                    $x->where('year', $yearOs)
                        ->where(function ($osQuery) use ($os4, $osInt) {
                            $osQuery->where('os', $os4)
                                ->orWhere('os', (string) $osInt)
                                ->orWhereRaw('LPAD(os, 4, "0") = ?', [$os4]);
                        });
                })
                    ->orWhereRaw('UPPER(CONCAT(year, "-", LPAD(os, 4, "0"))) = ?', [
                        strtoupper($yearOs . '-' . $os4),
                    ]);
            });
        });
    }
    public function versionesDe($cotizacion)
    {
        return Cotizacion::with(['cliente', 'motor'])
            ->where('cot_year', $cotizacion->cot_year)
            ->where('correlativo', $cotizacion->correlativo)
            ->where('letra', $cotizacion->letra)
            ->where('id', '!=', $cotizacion->id)
            ->orderByDesc('version')
            ->get();
    }
    public function osCotizacion($cotizacion)
    {
        if (!$cotizacion->motor) {
            return $cotizacion->equipo_no_ingresado_taller
                ? 'Oferta presupuestaria'
                : '-';
        }

        return $cotizacion->motor->fullos
            ?? trim(($cotizacion->motor->year ?? '') . '-' . ($cotizacion->motor->os ?? ''), '-');
    }

    public function potenciaCotizacion($cotizacion)
    {
        if (!$cotizacion->motor) {
            return '-';
        }

        return $cotizacion->motor->potencia ?: '-';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }

    public function simboloMoneda($moneda)
    {
        return $moneda === 'USD' ? '$' : 'Q';
    }

    public function totalUsd($cotizacion)
    {
        if ($cotizacion->moneda !== 'GTQ_USD') {
            return null;
        }

        if (!$cotizacion->tipo_cambio || $cotizacion->tipo_cambio <= 0) {
            return null;
        }

        return $cotizacion->total / $cotizacion->tipo_cambio;
    }
    public function toggleVersiones($cotizacionId)
    {
        if (in_array($cotizacionId, $this->versionesAbiertas)) {
            $this->versionesAbiertas = array_values(array_diff($this->versionesAbiertas, [$cotizacionId]));
            return;
        }

        $this->versionesAbiertas[] = $cotizacionId;
    }

    public function versionesEstanAbiertas($cotizacionId)
    {
        return in_array($cotizacionId, $this->versionesAbiertas);
    }
    public function confirmarEliminarVersion($cotizacionId)
    {
        $cotizacion = Cotizacion::find($cotizacionId);

        if (!$cotizacion) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'No encontrada',
                'text' => 'La versión de cotización no existe.',
            ]);

            return;
        }

        $this->dispatchBrowserEvent('confirmar-eliminar-version-cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'numero' => $cotizacion->numero,
        ]);
    }
    public function eliminarVersionCotizacion($cotizacionId)
    {
        $cotizacion = Cotizacion::find($cotizacionId);

        if (!$cotizacion) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'No encontrada',
                'text' => 'La versión de cotización no existe.',
            ]);

            return;
        }

        /*
     * Validar cuál es la versión más nueva del grupo.
     * Grupo = cot_year + correlativo + letra
     */
        $ultimaVersion = Cotizacion::where('cot_year', $cotizacion->cot_year)
            ->where('correlativo', $cotizacion->correlativo)
            ->where('letra', $cotizacion->letra)
            ->orderByDesc('version')
            ->orderByDesc('id')
            ->first();

        if ($ultimaVersion && (int) $ultimaVersion->id === (int) $cotizacion->id) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'No permitido',
                'text' => 'No se puede eliminar la versión más reciente de la cotización.',
            ]);

            return;
        }

        DB::transaction(function () use ($cotizacion) {
            /*
         * Si tienes FK con cascadeOnDelete, estas líneas no son necesarias.
         * Pero las dejo para evitar errores si no hay cascada configurada.
         */
            DB::table('cotizacion_items')
                ->where('cotizacion_id', $cotizacion->id)
                ->delete();

            DB::table('cotizacion_contactos')
                ->where('cotizacion_id', $cotizacion->id)
                ->delete();

            $cotizacion->delete();
        });

        $this->dispatchBrowserEvent('swal-success', [
            'title' => 'Versión eliminada',
            'text' => 'La versión ' . $cotizacion->numero . ' fue eliminada correctamente.',
        ]);
    }
    public function unificarCotizaciones()
    {
        $ids = collect($this->cotizacionesSeleccionadas)
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($ids->count() < 2) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'Seleccione más de una cotización',
                'text' => 'Debe seleccionar al menos dos cotizaciones para unificarlas.',
            ]);

            return;
        }

        $cotizaciones = Cotizacion::whereIn('id', $ids)
            ->get();

        if ($cotizaciones->count() !== $ids->count()) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'Cotizaciones no encontradas',
                'text' => 'Una o más cotizaciones seleccionadas ya no existen.',
            ]);

            return;
        }

        /*
     * Validar mismo cliente.
     */
        $clientes = $cotizaciones
            ->pluck('id_cliente')
            ->filter()
            ->unique()
            ->values();

        if ($clientes->count() !== 1) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'Clientes diferentes',
                'text' => 'Solo puede unificar cotizaciones del mismo cliente.',
            ]);

            return;
        }

        /*
     * Validar que todas sean la versión más reciente.
     */
        foreach ($cotizaciones as $cotizacion) {
            $ultimaVersion = Cotizacion::where('cot_year', $cotizacion->cot_year)
                ->where('correlativo', $cotizacion->correlativo)
                ->where('letra', $cotizacion->letra)
                ->orderByDesc('version')
                ->orderByDesc('id')
                ->first();

            if (!$ultimaVersion || (int) $ultimaVersion->id !== (int) $cotizacion->id) {
                $this->dispatchBrowserEvent('swal-error', [
                    'title' => 'Versión no vigente',
                    'text' => 'Solo puede unificar la versión más reciente de cada cotización.',
                ]);

                return;
            }
        }

        return redirect()->route('admin.cotizaciones.unificar', [
            'ids' => $ids->implode(','),
        ]);
    }
    public function adicionalesDeCotizacion($cotizacion)
    {
        return Cotizacion::with([
            'cliente',
            'motor',
            'motor.infoMotor',
        ])
            ->where('cot_year', $cotizacion->cot_year)
            ->where('correlativo', $cotizacion->correlativo)
            ->where('letra', '!=', 'A')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('cotizaciones')
                    ->groupBy('cot_year', 'correlativo', 'letra');
            })
            ->orderBy('letra')
            ->get();
    }
    public function abrirModalAdminCotizacion($cotizacionId)
    {
        $this->resetValidation();

        $cotizacion = Cotizacion::with([
            'motor.adminStatus.documentos.uploadedBy',
        ])->findOrFail($cotizacionId);

        if (! $cotizacion->id_motor || ! $cotizacion->motor) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'Cotización sin orden',
                'text' => 'Esta cotización no tiene motor ingresado al taller. Esta parte la manejaremos después como lead.',
            ]);

            return;
        }

        $admin = $cotizacion->motor->adminStatus;

        if (! $admin) {
            $admin = MotorAdminStatus::create([
                'id_motor' => $cotizacion->id_motor,
                'cotizacion_estado' => 'cotizado',
                'cotizacion_id' => $cotizacion->id,
                'cotizacion_fecha' => $cotizacion->fecha_cotizacion,
            ]);
        }

        if (! $admin->cotizacion_id) {
            $admin->cotizacion_estado = 'cotizado';
            $admin->cotizacion_id = $cotizacion->id;
            $admin->cotizacion_fecha = $cotizacion->fecha_cotizacion;
            $admin->save();
        }

        $this->selectedCotizacionId = $cotizacion->id;
        $this->selectedMotorId = $cotizacion->id_motor;
        $this->adminStatusId = $admin->id;
        $this->cotizacion_estado = $admin->cotizacion_estado;

        $this->requerimiento_estado = $admin->requerimiento_estado;
        $this->requerimiento_numero = $admin->requerimiento_numero;

        $this->oc_estado = $admin->oc_estado;
        $this->oc_numero = $admin->oc_numero;

        $this->autorizacion_estado = $admin->autorizacion_estado;
        $this->autorizacion_comentario = $admin->autorizacion_comentario;

        $this->anticipo_estado = $admin->anticipo_estado;
        $this->anticipo_monto = $admin->anticipo_monto;

        $this->aceptacion_estado = $admin->aceptacion_estado;
        $this->aceptacion_numero = $admin->aceptacion_numero;

        $this->factura_estado = $admin->factura_estado;
        $this->factura_numero = $admin->factura_numero;

        $this->contrasena_pago_estado = $admin->contrasena_pago_estado;
        $this->contrasena_pago_numero = $admin->contrasena_pago_numero;

        $this->pago_estado = $admin->pago_estado;

        $this->comentarios = $admin->comentarios;

        $this->cargarResumenDocumentosAdmin();

        $this->dispatchBrowserEvent('abrir-modal-admin-status');
    }
    private function cargarResumenDocumentosAdmin()
    {
        if (! $this->adminStatusId) {
            $this->adminDocumentosResumen = [];
            return;
        }

        $documentos = MotorAdminStatusDocument::where('motor_admin_status_id', $this->adminStatusId)
            ->latest()
            ->get()
            ->groupBy('tipo');

        $this->adminDocumentosResumen = $documentos
            ->map(function ($docs) {
                return $docs->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'tipo' => $doc->tipo,
                        'url' => $doc->url,
                        'archivo_original' => $doc->archivo_original,
                        'mime_type' => $doc->mime_type,
                        'es_pdf' => $doc->es_pdf,
                        'es_imagen' => $doc->es_imagen,
                        'nombre' => $this->documentoNombreVisible($doc),
                    ];
                })->values()->toArray();
            })
            ->toArray();
    }
    public function documentoNombreVisible($documento)
    {
        $tipo = $this->documentoTipoLabel($documento->tipo);

        if ($documento->archivo_original && str_contains($documento->archivo_original, 'captura_portapapeles')) {
            return 'Screenshot ' . $tipo;
        }

        if ($documento->comentario) {
            return $tipo . ': ' . $documento->comentario;
        }

        return $tipo;
    }
    public function documentoTipoLabel($tipo)
    {
        return [
            'oc' => 'OC',
            'factura' => 'Factura',
            'contrasena_pago' => 'Contraseña',
            'pago' => 'Pago',
            'requerimiento' => 'Requerimiento',
            'aceptacion' => 'Aceptación',
            'anticipo' => 'Anticipo',
        ][$tipo] ?? ucfirst((string) $tipo);
    }
    public function confirmarEliminarCotizacion($cotizacionId)
    {
        $cotizacion = Cotizacion::find($cotizacionId);

        if (! $cotizacion) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'Cotización no encontrada',
                'text' => 'La cotización ya no existe o fue eliminada previamente.',
            ]);

            return;
        }

        $this->dispatchBrowserEvent('confirmar-eliminar-cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'numero' => $cotizacion->numero,
        ]);
    }
    public function eliminarCotizacion($cotizacionId)
    {
        $cotizacion = Cotizacion::find($cotizacionId);

        if (! $cotizacion) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'Cotización no encontrada',
                'text' => 'La cotización ya no existe o fue eliminada previamente.',
            ]);

            return;
        }

        DB::transaction(function () use ($cotizacion) {
            $idMotor = $cotizacion->id_motor;
            $cotizacionId = $cotizacion->id;

            /*
         * 1. Eliminar PDFs adjuntos.
         * Si el archivo físico no lo usa otra cotización, también se borra del storage.
         */
            $adjuntos = CotizacionPdfAdjunto::where('cotizacion_id', $cotizacionId)->get();

            foreach ($adjuntos as $adjunto) {
                $path = $adjunto->path;

                $adjunto->delete();

                if ($path) {
                    $usadoPorOtros = CotizacionPdfAdjunto::where('path', $path)->exists();

                    if (! $usadoPorOtros) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            /*
         * 2. Eliminar relaciones directas.
         */
            CotizacionItem::where('cotizacion_id', $cotizacionId)->delete();
            CotizacionContacto::where('cotizacion_id', $cotizacionId)->delete();

            /*
         * 3. Eliminar detalles si es una cotización unificada.
         */
            CotizacionUnificadaDetalle::where('cotizacion_unificada_id', $cotizacionId)
                ->orWhere('cotizacion_origen_id', $cotizacionId)
                ->delete();

            /*
         * 4. Eliminar la cotización principal.
         */
            $cotizacion->delete();

            /*
         * 5. Resincronizar tablero administrativo si esta cotización tenía OS.
         */
            if ($idMotor) {
                $this->resincronizarAdminStatusDespuesDeEliminarCotizacion($idMotor, $cotizacionId);
            }
        });

        $this->dispatchBrowserEvent('cotizacion-eliminada', [
            'message' => 'La cotización fue eliminada correctamente.',
        ]);
    }
    private function resincronizarAdminStatusDespuesDeEliminarCotizacion($idMotor, $cotizacionEliminadaId)
    {
        $admin = MotorAdminStatus::where('id_motor', $idMotor)->first();

        if (! $admin) {
            return;
        }

        /*
     * Solo tocamos el tablero administrativo si apuntaba a la cotización eliminada.
     */
        if ((int) $admin->cotizacion_id !== (int) $cotizacionEliminadaId) {
            return;
        }

        /*
     * Buscar otra cotización interna para la misma OS.
     */
        $ultimaCotizacion = Cotizacion::where('id_motor', $idMotor)
            ->orderByDesc('id')
            ->first();

        if ($ultimaCotizacion) {
            $admin->update([
                'cotizacion_estado' => 'cotizado',
                'cotizacion_id' => $ultimaCotizacion->id,
                'cotizacion_fecha' => $ultimaCotizacion->fecha_cotizacion,
                'updated_by' => auth()->id(),
            ]);

            return;
        }

        /*
     * Si no queda cotización interna, pero hay cotización externa cargada,
     * se mantiene como cotizado.
     */
        $tieneCotizacionExterna = MotorAdminStatusDocument::where('motor_admin_status_id', $admin->id)
            ->where('tipo', 'cotizacion_externa')
            ->exists();

        if ($tieneCotizacionExterna) {
            $admin->update([
                'cotizacion_estado' => 'cotizado',
                'cotizacion_id' => null,
                'cotizacion_fecha' => $admin->cotizacion_fecha,
                'updated_by' => auth()->id(),
            ]);

            return;
        }

        /*
     * Si no queda cotización interna ni externa, vuelve a pendiente.
     */
        $admin->update([
            'cotizacion_estado' => 'pendiente',
            'cotizacion_id' => null,
            'cotizacion_fecha' => null,
            'updated_by' => auth()->id(),
        ]);
    }
}
