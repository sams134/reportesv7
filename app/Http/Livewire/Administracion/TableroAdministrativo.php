<?php

namespace App\Http\Livewire\Administracion;

use App\Models\Cotizacion;
use App\Models\Motor;
use App\Models\MotorAdminStatus;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MotorAdminStatusDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class TableroAdministrativo extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $ver = 'todos';

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

    public $statuses;

    public $infoTipo;
    public $infoTitulo;
    public $infoFile;
    public $infoPastedImageData;
    public $infoComentario;
    public $infoDocumentos = [];
    public $adminDocumentosResumen = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'ver' => ['except' => 'pendientes_cotizar'],
    ];

    public function mount()
    {
        $this->statuses = Status::all();
    }

    public function render()
    {
        $motores = Motor::with([
            'cliente',
            'tecnicos',
            'adminStatus.cotizacion',
            'adminStatus.documentos.uploadedBy',
        ])
            ->where('year', 'like', '2M%');

        $this->aplicarBusqueda($motores);
        $this->aplicarFiltroVista($motores);

        $motores = $motores
            ->orderBy('year', 'desc')
            ->orderBy('os', 'desc')
            ->paginate(100);

        return view('livewire.administracion.tablero-administrativo', [
            'motores' => $motores,
        ]);
    }

    private function aplicarBusqueda($query)
    {
        $search = trim($this->search);

        if ($search === '') {
            return;
        }

        if (strpos($search, '-') !== false) {
            $parts = explode('-', $search, 2);

            if (count($parts) === 2) {
                $yearSearch = trim($parts[0]);
                $osSearch = str_pad(trim($parts[1]), 4, '0', STR_PAD_LEFT);

                $query->where('year', 'like', "%{$yearSearch}")
                    ->where(function ($q) use ($osSearch) {
                        $q->where('os', 'like', "{$osSearch}%")
                            ->orWhereRaw('LPAD(os, 4, "0") LIKE ?', ["{$osSearch}%"]);
                    });

                return;
            }
        }

        if (is_numeric($search)) {
            $os = str_pad($search, 4, '0', STR_PAD_LEFT);

            $query->where(function ($q) use ($os, $search) {
                $q->where('os', 'like', "{$os}%")
                    ->orWhere('os', 'like', "{$search}%")
                    ->orWhereRaw('LPAD(os, 4, "0") LIKE ?', ["{$os}%"]);
            });

            return;
        }

        $query->where(function ($q) use ($search) {
            $q->whereHas('cliente', function ($cliente) use ($search) {
                $cliente->where('cliente', 'like', "%{$search}%");
            })
                ->orWhereHas('tecnicos', function ($tecnico) use ($search) {
                    $tecnico->where('name', 'like', "%{$search}%");
                });
        });
    }

    private function aplicarFiltroVista($query)
    {
        switch ($this->ver) {
            case 'pendientes_cotizar':
                $query->where(function ($q) {
                    $q->whereDoesntHave('adminStatus')
                        ->orWhereHas('adminStatus', function ($admin) {
                            $admin->where('cotizacion_estado', 'pendiente');
                        });
                });
                break;

            case 'cotizados_sin_oc':
                $query->whereHas('adminStatus', function ($admin) {
                    $admin->where('cotizacion_estado', 'cotizado')
                        ->where('oc_estado', 'pendiente');
                });
                break;

            case 'con_oc_sin_aceptacion':
                $query->whereHas('adminStatus', function ($admin) {
                    $admin->where('oc_estado', 'recibida')
                        ->where('aceptacion_estado', 'pendiente');
                });
                break;

            case 'pendientes_factura':
                $query->whereHas('adminStatus', function ($admin) {
                    $admin->whereIn('aceptacion_estado', ['recibida', 'no_aplica'])
                        ->where('factura_estado', 'pendiente');
                });
                break;

            case 'pendientes_pago':
                $query->whereHas('adminStatus', function ($admin) {
                    $admin->where('factura_estado', 'emitida')
                        ->where('pago_estado', 'pendiente');
                });
                break;

            case 'todos':
            default:
                break;
        }
    }

    public function abrirModalAdministrativo($idMotor)
    {
        $motor = Motor::with('adminStatus')->findOrFail($idMotor);

        $admin = $motor->adminStatus;

        if (! $admin) {
            $admin = MotorAdminStatus::create([
                'id_motor' => $motor->id_motor,
            ]);
        }

        $this->selectedMotorId = $motor->id_motor;
        $this->adminStatusId = $admin->id;

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

    public function guardarAdminStatus()
    {
        $this->validate([
            'adminStatusId' => 'required|exists:motor_admin_statuses,id',

            'requerimiento_estado' => 'required|in:pendiente,recibido,no_aplica',
            'requerimiento_numero' => 'nullable|string|max:191',

            'oc_estado' => 'required|in:pendiente,recibida,no_aplica',
            'oc_numero' => 'nullable|string|max:191',

            'autorizacion_estado' => 'required|in:pendiente,verbal,previa,confianza,recibida,no_aplica',
            'autorizacion_comentario' => 'nullable|string',

            'anticipo_estado' => 'required|in:pendiente,solicitado,recibido,no_aplica',
            'anticipo_monto' => 'nullable|numeric|min:0',

            'aceptacion_estado' => 'required|in:pendiente,recibida,no_aplica',
            'aceptacion_numero' => 'nullable|string|max:191',

            'factura_estado' => 'required|in:pendiente,emitida,enviada,no_aplica',
            'factura_numero' => 'nullable|string|max:191',

            'contrasena_pago_estado' => 'required|in:pendiente,recibida,no_aplica',
            'contrasena_pago_numero' => 'nullable|string|max:191',

            'pago_estado' => 'required|in:pendiente,pagado,no_aplica',

            'comentarios' => 'nullable|string',
        ]);

        $this->normalizarEstadosPorDatosIngresados();

        $admin = MotorAdminStatus::findOrFail($this->adminStatusId);

        $admin->update([
            'requerimiento_estado' => $this->requerimiento_estado,
            'requerimiento_numero' => $this->requerimiento_numero,
            'requerimiento_fecha' => $this->requerimiento_estado === 'recibido' ? now() : $admin->requerimiento_fecha,

            'oc_estado' => $this->oc_estado,
            'oc_numero' => $this->oc_numero,
            'oc_fecha' => $this->oc_estado === 'recibida' ? now() : $admin->oc_fecha,

            'autorizacion_estado' => $this->autorizacion_estado,
            'autorizacion_comentario' => $this->autorizacion_comentario,
            'autorizacion_fecha' => $this->autorizacion_estado !== 'pendiente' ? now() : $admin->autorizacion_fecha,

            'anticipo_estado' => $this->anticipo_estado,
            'anticipo_monto' => $this->anticipo_monto,
            'anticipo_fecha' => $this->anticipo_estado === 'recibido' ? now() : $admin->anticipo_fecha,

            'aceptacion_estado' => $this->aceptacion_estado,
            'aceptacion_numero' => $this->aceptacion_numero,
            'aceptacion_fecha' => $this->aceptacion_estado === 'recibida' ? now() : $admin->aceptacion_fecha,

            'factura_estado' => $this->factura_estado,
            'factura_numero' => $this->factura_numero,
            'factura_fecha' => in_array($this->factura_estado, ['emitida', 'enviada']) ? now() : $admin->factura_fecha,

            'contrasena_pago_estado' => $this->contrasena_pago_estado,
            'contrasena_pago_numero' => $this->contrasena_pago_numero,
            'contrasena_pago_fecha' => $this->contrasena_pago_estado === 'recibida' ? now() : $admin->contrasena_pago_fecha,

            'pago_estado' => $this->pago_estado,
            'pago_fecha' => $this->pago_estado === 'pagado' ? now() : $admin->pago_fecha,

            'comentarios' => $this->comentarios,
            'updated_by' => auth()->id(),
        ]);

        $this->dispatchBrowserEvent('cerrar-modal-admin-status');
        $this->dispatchBrowserEvent('admin-status-actualizado');
    }

    public function badgeClass($estado, $tipo = null)
    {
        if (in_array($estado, ['cotizado', 'recibida', 'recibido', 'emitida', 'enviada', 'pagado'])) {
            return 'bg-success';
        }

        if (in_array($estado, ['verbal', 'previa', 'confianza', 'solicitado'])) {
            return 'bg-warning text-dark';
        }

        if ($estado === 'no_aplica') {
            return 'bg-secondary';
        }

        return 'bg-danger';
    }

    public function badgeLabel($estado)
    {
        return str_replace('_', ' ', ucfirst($estado ?? 'pendiente'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedVer()
    {
        $this->resetPage();
    }
    public function abrirModalInfo($tipo)
    {
        $this->resetValidation();

        $this->infoTipo = $tipo;
        $this->infoTitulo = $this->tituloTipoInfo($tipo);
        $this->infoFile = null;
        $this->infoPastedImageData = null;
        $this->infoComentario = '';

        if (! $this->adminStatusId) {
            $this->addError('infoFile', 'Primero debe abrir una orden administrativa.');
            return;
        }

        $this->cargarDocumentosInfo();

        $this->dispatchBrowserEvent('abrir-modal-admin-info');
    }

    private function tituloTipoInfo($tipo)
    {
        return [
            'oc' => 'Orden de Compra',
            'factura' => 'Factura',
            'contrasena_pago' => 'Contraseña de pago',
            'pago' => 'Pago',
            'requerimiento' => 'Requerimiento',
            'aceptacion' => 'Aceptación',
            'anticipo' => 'Anticipo',
        ][$tipo] ?? 'Información administrativa';
    }

    private function cargarDocumentosInfo()
    {
        if (! $this->adminStatusId || ! $this->infoTipo) {
            $this->infoDocumentos = [];
            return;
        }

        $this->infoDocumentos = MotorAdminStatusDocument::with('uploadedBy')
            ->where('motor_admin_status_id', $this->adminStatusId)
            ->where('tipo', $this->infoTipo)
            ->latest()
            ->get()
            ->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'archivo_original' => $doc->archivo_original,
                    'archivo_path' => $doc->archivo_path,
                    'url' => $doc->url,
                    'mime_type' => $doc->mime_type,
                    'es_pdf' => $doc->es_pdf,
                    'es_imagen' => $doc->es_imagen,
                    'comentario' => $doc->comentario,
                    'uploaded_by' => optional($doc->uploadedBy)->name,
                    'created_at' => optional($doc->created_at)->format('d/m/Y h:i A'),
                ];
            })
            ->toArray();
    }

    public function guardarInfoDocumento()
    {
        $this->validate([
            'adminStatusId' => 'required|exists:motor_admin_statuses,id',
            'infoTipo' => 'required|in:oc,factura,contrasena_pago,pago,requerimiento,aceptacion,anticipo',
            'infoFile' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:10240',
            'infoPastedImageData' => 'nullable|string',
            'infoComentario' => 'nullable|string|max:1000',
        ], [
            'infoFile.mimes' => 'Solo se permiten imágenes JPG, PNG, WEBP o documentos PDF.',
            'infoFile.max' => 'El archivo no debe pesar más de 10 MB.',
        ]);

        if (! $this->infoFile && ! $this->infoPastedImageData) {
            $this->addError('infoFile', 'Debe cargar un PDF, una imagen o pegar una captura desde el portapapeles.');
            return;
        }

        try {
            if ($this->infoFile) {
                $this->guardarArchivoSubido();
            } else {
                $this->guardarImagenPegada();
            }

            /*
 * Si se carga evidencia, actualizamos automáticamente el estado administrativo.
 */
            $this->marcarEstadoPorEvidencia($this->infoTipo);

            $this->infoFile = null;
            $this->infoPastedImageData = null;
            $this->infoComentario = '';

            $this->cargarDocumentosInfo();
            $this->cargarResumenDocumentosAdmin();

            $this->dispatchBrowserEvent('admin-info-guardada');
        } catch (\Exception $e) {
            report($e);

            $this->addError('infoFile', 'No se pudo guardar el archivo. Error: ' . $e->getMessage());
        }
    }

    private function guardarArchivoSubido()
    {
        $extension = strtolower($this->infoFile->getClientOriginalExtension());
        $original = $this->infoFile->getClientOriginalName();

        $folder = 'admin-status/' . $this->adminStatusId . '/' . $this->infoTipo;

        $filename = now()->format('Ymd_His') . '_' . Str::random(12) . '.' . $extension;

        $path = $this->infoFile->storeAs($folder, $filename, 'public');

        MotorAdminStatusDocument::create([
            'motor_admin_status_id' => $this->adminStatusId,
            'tipo' => $this->infoTipo,
            'archivo_path' => $path,
            'archivo_original' => $original,
            'mime_type' => $this->infoFile->getMimeType(),
            'size_bytes' => $this->infoFile->getSize(),
            'comentario' => $this->infoComentario,
            'uploaded_by' => auth()->id(),
        ]);
    }

    private function guardarImagenPegada()
    {
        $data = $this->infoPastedImageData;

        if (! preg_match('/^data:image\/(png|jpeg|jpg|webp);base64,/', $data, $matches)) {
            throw new \Exception('La imagen pegada no tiene un formato válido.');
        }

        $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];

        $base64 = preg_replace('/^data:image\/(png|jpeg|jpg|webp);base64,/', '', $data);
        $base64 = str_replace(' ', '+', $base64);

        $binary = base64_decode($base64);

        if ($binary === false) {
            throw new \Exception('No se pudo leer la imagen pegada.');
        }

        $folder = 'admin-status/' . $this->adminStatusId . '/' . $this->infoTipo;
        $filename = now()->format('Ymd_His') . '_clipboard_' . Str::random(12) . '.' . $extension;
        $path = $folder . '/' . $filename;

        Storage::disk('public')->put($path, $binary);

        MotorAdminStatusDocument::create([
            'motor_admin_status_id' => $this->adminStatusId,
            'tipo' => $this->infoTipo,
            'archivo_path' => $path,
            'archivo_original' => 'captura_portapapeles.' . $extension,
            'mime_type' => 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension),
            'size_bytes' => strlen($binary),
            'comentario' => $this->infoComentario,
            'uploaded_by' => auth()->id(),
        ]);
    }

    public function eliminarInfoDocumento($documentoId)
    {
        $documento = MotorAdminStatusDocument::findOrFail($documentoId);

        if ((int) $documento->motor_admin_status_id !== (int) $this->adminStatusId) {
            abort(403);
        }

        if (Storage::disk('public')->exists($documento->archivo_path)) {
            Storage::disk('public')->delete($documento->archivo_path);
        }

        $documento->delete();

        $this->cargarDocumentosInfo();
        $this->cargarResumenDocumentosAdmin();

        $this->dispatchBrowserEvent('admin-info-eliminada');
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

    public function documentoIcono($documento)
    {
        if ($documento->es_pdf) {
            return 'far fa-file-pdf text-danger';
        }

        if ($documento->es_imagen) {
            return 'far fa-image text-primary';
        }

        return 'far fa-file-alt text-secondary';
    }

    public function documentoBadgeClass($documento)
    {
        if ($documento->es_pdf) {
            return 'border-danger text-danger bg-white';
        }

        if ($documento->es_imagen) {
            return 'border-primary text-primary bg-white';
        }

        return 'border-secondary text-secondary bg-white';
    }
    private function normalizarEstadosPorDatosIngresados()
    {
        /*
     * Si se ingresa número de OC, asumimos OC recibida.
     */
        if (filled($this->oc_numero) && in_array($this->oc_estado, ['pendiente', 'no_aplica'])) {
            $this->oc_estado = 'recibida';
        }

        /*
     * Si se ingresa número de factura, asumimos factura emitida.
     * En tu enum no existe "recibida" para factura; existe pendiente, emitida, enviada, no_aplica.
     */
        if (filled($this->factura_numero) && in_array($this->factura_estado, ['pendiente', 'no_aplica'])) {
            $this->factura_estado = 'emitida';
        }

        /*
     * Si se ingresa número de contraseña, asumimos contraseña recibida.
     */
        if (filled($this->contrasena_pago_numero) && in_array($this->contrasena_pago_estado, ['pendiente', 'no_aplica'])) {
            $this->contrasena_pago_estado = 'recibida';
        }

        /*
     * IMPORTANTE:
     * No tocamos autorizacion_estado por autorizacion_comentario.
     * Ese campo puede ser solo una nota narrativa.
     */
    }
    private function marcarEstadoPorEvidencia($tipo)
    {
        $admin = MotorAdminStatus::findOrFail($this->adminStatusId);

        $updates = [
            'updated_by' => auth()->id(),
        ];

        switch ($tipo) {
            case 'oc':
                $updates['oc_estado'] = 'recibida';
                $updates['oc_fecha'] = $admin->oc_fecha ?: now();

                $this->oc_estado = 'recibida';
                break;

            case 'factura':
                $updates['factura_estado'] = 'emitida';
                $updates['factura_fecha'] = $admin->factura_fecha ?: now();

                $this->factura_estado = 'emitida';
                break;

            case 'contrasena_pago':
                $updates['contrasena_pago_estado'] = 'recibida';
                $updates['contrasena_pago_fecha'] = $admin->contrasena_pago_fecha ?: now();

                $this->contrasena_pago_estado = 'recibida';
                break;

            case 'pago':
                $updates['pago_estado'] = 'pagado';
                $updates['pago_fecha'] = $admin->pago_fecha ?: now();

                $this->pago_estado = 'pagado';
                break;
        }

        $admin->update($updates);
    }
    public function updatedInfoFile()
    {
        if ($this->infoFile) {
            $this->infoPastedImageData = null;
        }
    }

    public function updatedInfoPastedImageData()
    {
        if ($this->infoPastedImageData) {
            $this->infoFile = null;
        }
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
}
