<?php

namespace App\Http\Livewire\Traits;

use App\Models\MotorAdminStatus;
use App\Models\MotorAdminStatusDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


trait HandlesMotorAdminStatus
{
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
        $this->resetValidation([
            'infoFile',
            'infoPastedImageData',
            'infoComentario',
            'infoTipo',
        ]);

        $this->cargarDocumentosInfo();

        $this->dispatchBrowserEvent('limpiar-admin-info-file-input');
        $this->dispatchBrowserEvent('abrir-modal-admin-info');
    }

    private function tituloTipoInfo($tipo)
    {
        return [
            'cotizacion_externa' => 'Cotización externa',
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
            'infoTipo' => 'required|in:cotizacion_externa,oc,factura,contrasena_pago,pago,requerimiento,aceptacion,anticipo',
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

            $this->marcarEstadoPorEvidencia($this->infoTipo);

            $this->infoFile = null;
            $this->infoPastedImageData = null;
            $this->infoComentario = '';

            $this->resetValidation([
                'infoFile',
                'infoPastedImageData',
                'infoComentario',
                'infoTipo',
            ]);

            $this->cargarDocumentosInfo();
            $this->cargarResumenDocumentosAdmin();

            $this->dispatchBrowserEvent('limpiar-admin-info-file-input');
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

    private function marcarEstadoPorEvidencia($tipo)
    {
        $admin = MotorAdminStatus::findOrFail($this->adminStatusId);

        $updates = [
            'updated_by' => auth()->id(),
        ];

        switch ($tipo) {
            case 'cotizacion_externa':
                $updates['cotizacion_estado'] = 'cotizado';
                $updates['cotizacion_fecha'] = $admin->cotizacion_fecha ?: now();

                /*
     * No tocamos cotizacion_id.
     * Si ya existe una cotización del sistema, la respetamos.
     * Si no existe, queda NULL porque esta cotización es externa.
     */
                if (property_exists($this, 'cotizacion_estado')) {
                    $this->cotizacion_estado = 'cotizado';
                }
                break;
            case 'requerimiento':
                $updates['requerimiento_estado'] = 'recibido';
                $updates['requerimiento_fecha'] = $admin->requerimiento_fecha ?: now();
                $this->requerimiento_estado = 'recibido';
                break;

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

            case 'aceptacion':
                $updates['aceptacion_estado'] = 'recibida';
                $updates['aceptacion_fecha'] = $admin->aceptacion_fecha ?: now();
                $this->aceptacion_estado = 'recibida';
                break;

            case 'anticipo':
                $updates['anticipo_estado'] = 'recibido';
                $updates['anticipo_fecha'] = $admin->anticipo_fecha ?: now();
                $this->anticipo_estado = 'recibido';
                break;
        }

        $admin->update($updates);
    }

    public function eliminarInfoDocumento($documentoId)
    {
        if (! $this->adminStatusId) {
            return;
        }

        $documento = MotorAdminStatusDocument::where('id', $documentoId)
            ->where('motor_admin_status_id', $this->adminStatusId)
            ->firstOrFail();

        $tipo = $documento->tipo;

        if ($documento->archivo_path) {
            Storage::disk('public')->delete($documento->archivo_path);
        }

        $documento->delete();

        $this->revertirEstadoSiNoHayEvidencia($tipo);

        $this->cargarDocumentosInfo();
        $this->cargarResumenDocumentosAdmin();

        $this->dispatchBrowserEvent('admin-info-eliminada', [
            'message' => 'Documento eliminado correctamente.',
        ]);
    }
    private function revertirEstadoSiNoHayEvidencia($tipo)
    {
        if (! $this->adminStatusId) {
            return;
        }

        $admin = MotorAdminStatus::find($this->adminStatusId);

        if (! $admin) {
            return;
        }

        $quedanDocumentos = MotorAdminStatusDocument::where('motor_admin_status_id', $admin->id)
            ->where('tipo', $tipo)
            ->exists();

        if ($quedanDocumentos) {
            return;
        }

        $updates = [];

        switch ($tipo) {
            case 'cotizacion_externa':
                /*
             * Solo vuelve a pendiente si no hay cotización interna del sistema.
             * Si existe cotizacion_id, se mantiene como cotizado.
             */
                if (blank($admin->cotizacion_id)) {
                    $updates['cotizacion_estado'] = 'pendiente';
                    $updates['cotizacion_fecha'] = null;

                    if (property_exists($this, 'cotizacion_estado')) {
                        $this->cotizacion_estado = 'pendiente';
                    }
                }
                break;

            case 'requerimiento':
                if (blank($admin->requerimiento_numero)) {
                    $updates['requerimiento_estado'] = 'pendiente';
                    $updates['requerimiento_fecha'] = null;

                    if (property_exists($this, 'requerimiento_estado')) {
                        $this->requerimiento_estado = 'pendiente';
                    }
                }
                break;

            case 'oc':
                if (blank($admin->oc_numero)) {
                    $updates['oc_estado'] = 'pendiente';
                    $updates['oc_fecha'] = null;

                    if (property_exists($this, 'oc_estado')) {
                        $this->oc_estado = 'pendiente';
                    }
                }
                break;

            case 'aceptacion':
                if (blank($admin->aceptacion_numero)) {
                    $updates['aceptacion_estado'] = 'pendiente';
                    $updates['aceptacion_fecha'] = null;

                    if (property_exists($this, 'aceptacion_estado')) {
                        $this->aceptacion_estado = 'pendiente';
                    }
                }
                break;

            case 'factura':
                if (blank($admin->factura_numero)) {
                    $updates['factura_estado'] = 'pendiente';
                    $updates['factura_fecha'] = null;

                    if (property_exists($this, 'factura_estado')) {
                        $this->factura_estado = 'pendiente';
                    }
                }
                break;

            case 'contrasena_pago':
                if (blank($admin->contrasena_pago_numero)) {
                    $updates['contrasena_pago_estado'] = 'pendiente';
                    $updates['contrasena_pago_fecha'] = null;

                    if (property_exists($this, 'contrasena_pago_estado')) {
                        $this->contrasena_pago_estado = 'pendiente';
                    }
                }
                break;

            case 'pago':
                $updates['pago_estado'] = 'pendiente';
                $updates['pago_fecha'] = null;

                if (property_exists($this, 'pago_estado')) {
                    $this->pago_estado = 'pendiente';
                }
                break;

            case 'anticipo':
                if (blank($admin->anticipo_monto)) {
                    $updates['anticipo_estado'] = 'pendiente';
                    $updates['anticipo_fecha'] = null;

                    if (property_exists($this, 'anticipo_estado')) {
                        $this->anticipo_estado = 'pendiente';
                    }
                }
                break;
        }

        if (! empty($updates)) {
            $updates['updated_by'] = auth()->id();

            $admin->update($updates);
        }
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
            'requerimiento_fecha' => $this->requerimiento_estado === 'recibido' ? ($admin->requerimiento_fecha ?: now()) : $admin->requerimiento_fecha,

            'oc_estado' => $this->oc_estado,
            'oc_numero' => $this->oc_numero,
            'oc_fecha' => $this->oc_estado === 'recibida' ? ($admin->oc_fecha ?: now()) : $admin->oc_fecha,

            'autorizacion_estado' => $this->autorizacion_estado,
            'autorizacion_comentario' => $this->autorizacion_comentario,
            'autorizacion_fecha' => $this->autorizacion_estado !== 'pendiente' ? ($admin->autorizacion_fecha ?: now()) : $admin->autorizacion_fecha,

            'anticipo_estado' => $this->anticipo_estado,
            'anticipo_monto' => $this->anticipo_monto,
            'anticipo_fecha' => $this->anticipo_estado === 'recibido' ? ($admin->anticipo_fecha ?: now()) : $admin->anticipo_fecha,

            'aceptacion_estado' => $this->aceptacion_estado,
            'aceptacion_numero' => $this->aceptacion_numero,
            'aceptacion_fecha' => $this->aceptacion_estado === 'recibida' ? ($admin->aceptacion_fecha ?: now()) : $admin->aceptacion_fecha,

            'factura_estado' => $this->factura_estado,
            'factura_numero' => $this->factura_numero,
            'factura_fecha' => in_array($this->factura_estado, ['emitida', 'enviada']) ? ($admin->factura_fecha ?: now()) : $admin->factura_fecha,

            'contrasena_pago_estado' => $this->contrasena_pago_estado,
            'contrasena_pago_numero' => $this->contrasena_pago_numero,
            'contrasena_pago_fecha' => $this->contrasena_pago_estado === 'recibida' ? ($admin->contrasena_pago_fecha ?: now()) : $admin->contrasena_pago_fecha,

            'pago_estado' => $this->pago_estado,
            'pago_fecha' => $this->pago_estado === 'pagado' ? ($admin->pago_fecha ?: now()) : $admin->pago_fecha,

            'comentarios' => $this->comentarios,
            'updated_by' => auth()->id(),
        ]);

        $this->cargarResumenDocumentosAdmin();

        $this->dispatchBrowserEvent('cerrar-modal-admin-status');
        $this->dispatchBrowserEvent('admin-status-actualizado');
    }

    private function normalizarEstadosPorDatosIngresados()
    {
        if (filled($this->requerimiento_numero) && in_array($this->requerimiento_estado, ['pendiente', 'no_aplica'])) {
            $this->requerimiento_estado = 'recibido';
        }

        if (filled($this->oc_numero) && in_array($this->oc_estado, ['pendiente', 'no_aplica'])) {
            $this->oc_estado = 'recibida';
        }

        if (filled($this->factura_numero) && in_array($this->factura_estado, ['pendiente', 'no_aplica'])) {
            $this->factura_estado = 'emitida';
        }

        if (filled($this->contrasena_pago_numero) && in_array($this->contrasena_pago_estado, ['pendiente', 'no_aplica'])) {
            $this->contrasena_pago_estado = 'recibida';
        }

        if (filled($this->aceptacion_numero) && in_array($this->aceptacion_estado, ['pendiente', 'no_aplica'])) {
            $this->aceptacion_estado = 'recibida';
        }

        /*
         * No cambiamos autorización automáticamente por comentario.
         * Ese comentario puede ser solo narrativo.
         */
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

    protected function cargarResumenDocumentosAdmin()
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

    public function documentoTipoLabel($tipo)
    {
        return [
            'cotizacion_externa' => 'Cotización',
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
    public function confirmarEliminarInfoDocumento($documentoId)
    {
        $this->dispatchBrowserEvent('confirmar-eliminar-admin-documento', [
            'documento_id' => $documentoId,
        ]);
    }
}
