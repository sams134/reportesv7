<div>
    <x-pretty-card>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Tablero Administrativo</h2>
                <p class="mb-0 text-muted">
                    Estado administrativo de órdenes: cotización, requerimiento, OC, aceptación, factura y pago.
                </p>
            </div>

            <div class="text-end">
                <span class="badge bg-primary">
                    Vista administrativa
                </span>
            </div>
        </div>
    </x-pretty-card>

    <x-pretty-card>
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Buscar</label>
                <input type="search" class="form-control" placeholder="Buscar por OS, cliente o técnico..."
                    wire:model.debounce.500ms="search">
            </div>

            <div class="col-md-4">
                <label class="form-label">Vista</label>
                <select class="form-select" wire:model="ver">
                    <option value="pendientes_cotizar">Pendientes de cotizar</option>
                    <option value="cotizados_sin_oc">Cotizados sin OC</option>
                    <option value="con_oc_sin_aceptacion">Con OC sin aceptación</option>
                    <option value="pendientes_factura">Pendientes de factura</option>
                    <option value="pendientes_pago">Pendientes de pago</option>
                    <option value="todos">Todos</option>
                </select>
            </div>

            <div class="col-md-3 text-md-end">
                <div wire:loading.delay class="text-primary small">
                    Actualizando tablero...
                </div>
            </div>
        </div>
    </x-pretty-card>

    <div class="card mb-3">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Órdenes</h5>

                <div class="small text-muted">
                    {{ $motores->total() }} registros
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="px-3 pt-3">
                {{ $motores->links() }}
            </div>

            <div class="table-responsive scrollbar">
                <table class="table table-hover table-striped align-middle mb-0 fs--1">
                    <thead class="bg-300 text-dark">
                        <tr class="text-800">
                            <th>OS</th>
                            <th>Cliente</th>
                            <th>Equipo</th>
                            <th>Ingreso</th>
                            <th>Técnico</th>
                            <th>Status técnico</th>
                            <th class="text-center">Cotización</th>
                            <th class="text-center">Req.</th>
                            <th class="text-center">OC</th>
                            <th class="text-center">Autorización</th>
                            <th class="text-center">Anticipo</th>
                            <th class="text-center">Aceptación</th>
                            <th class="text-center">Factura</th>
                            <th class="text-center">Pago</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($motores as $motor)
                            @php
                                $admin = $motor->adminStatus;
                                $cotEstado = optional($admin)->cotizacion_estado ?? 'pendiente';
                                $reqEstado = optional($admin)->requerimiento_estado ?? 'pendiente';
                                $ocEstado = optional($admin)->oc_estado ?? 'pendiente';
                                $autEstado = optional($admin)->autorizacion_estado ?? 'pendiente';
                                $antEstado = optional($admin)->anticipo_estado ?? 'no_aplica';
                                $aceptEstado = optional($admin)->aceptacion_estado ?? 'pendiente';
                                $factEstado = optional($admin)->factura_estado ?? 'pendiente';
                                $pagoEstado = optional($admin)->pago_estado ?? 'pendiente';
                            @endphp

                            <tr>
                                <td class="fw-bold text-nowrap">
                                    <a href="{{ route('motores.show', $motor) }}">
                                        {{ $motor->fullOs }}
                                    </a>
                                </td>

                                <td>
                                    {{ optional($motor->cliente)->cliente }}
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $motor->potencia }}
                                    </div>

                                    <div class="text-muted small">
                                        {{ $motor->marca }}
                                        @if ($motor->rpm)
                                            · {{ $motor->rpm }} RPM
                                        @endif
                                    </div>
                                </td>

                                <td class="text-nowrap">
                                    @if ($motor->fecha_ingreso)
                                        {{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}
                                        <div class="text-muted small">
                                            {{ \Carbon\Carbon::parse($motor->fecha_ingreso)->diffForHumans() }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @forelse ($motor->tecnicos as $tecnico)
                                        <span class="badge bg-secondary">
                                            {{ $tecnico->name }}
                                        </span>
                                    @empty
                                        <span class="badge bg-danger">
                                            Sin asignar
                                        </span>
                                    @endforelse
                                </td>

                                <td>
                                    <x-status-badge status_id="{{ $motor->status_id }}" />
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($cotEstado) }}">
                                        {{ $cotEstado === 'cotizado' ? 'Cotizado' : $this->badgeLabel($cotEstado) }}
                                    </span>

                                    @if ($admin && $admin->cotizacion)
                                        <div class="small mt-1">
                                            <a href="{{ route('admin.cotizaciones.edit', $admin->cotizacion_id) }}">
                                                {{ $admin->cotizacion->numero }}
                                            </a>
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($reqEstado) }}">
                                        {{ $this->badgeLabel($reqEstado) }}
                                    </span>

                                    @if ($admin && $admin->requerimiento_numero)
                                        <div class="small text-muted">
                                            {{ $admin->requerimiento_numero }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($ocEstado) }}">
                                        {{ $this->badgeLabel($ocEstado) }}
                                    </span>

                                    @if ($admin && $admin->oc_numero)
                                        <div class="small text-muted">
                                            {{ $admin->oc_numero }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($autEstado) }}">
                                        {{ $this->badgeLabel($autEstado) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($antEstado) }}">
                                        {{ $this->badgeLabel($antEstado) }}
                                    </span>

                                    @if ($admin && $admin->anticipo_monto)
                                        <div class="small text-muted">
                                            Q{{ number_format($admin->anticipo_monto, 2) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($aceptEstado) }}">
                                        {{ $this->badgeLabel($aceptEstado) }}
                                    </span>

                                    @if ($admin && $admin->aceptacion_numero)
                                        <div class="small text-muted">
                                            {{ $admin->aceptacion_numero }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($factEstado) }}">
                                        {{ $this->badgeLabel($factEstado) }}
                                    </span>

                                    @if ($admin && $admin->factura_numero)
                                        <div class="small text-muted">
                                            {{ $admin->factura_numero }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge {{ $this->badgeClass($pagoEstado) }}">
                                        {{ $this->badgeLabel($pagoEstado) }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-falcon-primary"
                                        wire:click="abrirModalAdministrativo({{ $motor->id_motor }})">
                                        <i class="fas fa-edit me-1"></i>
                                        Admin
                                    </button>
                                </td>
                            </tr>
                            @if ($admin && $admin->documentos && $admin->documentos->count() > 0)
                                <tr class="bg-light">
                                    <td colspan="15" class="py-2">
                                        <div class="ms-4 ps-3 border-start border-3 border-primary">
                                            <div class="d-flex align-items-center flex-wrap gap-2">
                                                <span class="text-muted small me-2">
                                                    <i class="fas fa-paperclip me-1"></i>
                                                    Evidencias:
                                                </span>

                                                @foreach ($admin->documentos as $documento)
                                                    <a href="{{ $documento->url }}" target="_blank"
                                                        class="badge rounded-pill border {{ $this->documentoBadgeClass($documento) }} text-decoration-none px-3 py-2"
                                                        title="{{ $documento->archivo_original }}">
                                                        <i class="{{ $this->documentoIcono($documento) }} me-1"></i>
                                                        {{ $this->documentoNombreVisible($documento) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="15" class="text-center text-muted py-4">
                                    No hay órdenes para esta vista.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 py-3">
                {{ $motores->links() }}
            </div>
        </div>
    </div>

    {{-- Modal administrativo --}}
    <div wire:ignore.self class="modal fade" id="adminStatusModal" tabindex="-1"
        aria-labelledby="adminStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="adminStatusModalLabel">
                        Actualizar estado administrativo
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    @error('adminStatusId')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Requerimiento</label>
                            <select class="form-select" wire:model.defer="requerimiento_estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="recibido">Recibido</option>
                                <option value="no_aplica">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Número de requerimiento</label>
                            <input type="text" class="form-control" wire:model.defer="requerimiento_numero">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">OC</label>
                            <select class="form-select" wire:model.defer="oc_estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="recibida">Recibida</option>
                                <option value="no_aplica">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Número de OC</label>

                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.defer="oc_numero">

                                <button type="button" class="btn btn-outline-primary"
                                    wire:click="abrirModalInfo('oc')">
                                    <i class="fas fa-paperclip me-1"></i>
                                    Agregar info
                                </button>
                            </div>

                            @if (!empty($adminDocumentosResumen['oc']))
                                <div class="d-flex align-items-center flex-wrap gap-1 mt-1">
                                    @foreach ($adminDocumentosResumen['oc'] as $doc)
                                        <a href="{{ $doc['url'] }}" target="_blank"
                                            class="d-inline-flex align-items-center text-decoration-none border rounded px-1 py-1 bg-light"
                                            style="max-width: 180px;" title="{{ $doc['archivo_original'] }}">
                                            @if ($doc['es_imagen'])
                                                <img src="{{ $doc['url'] }}" class="rounded border me-1"
                                                    style="width:25px; height:25px; object-fit:cover;">
                                            @elseif ($doc['es_pdf'])
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file-pdf" style="font-size:13px;"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file" style="font-size:13px;"></i>
                                                </span>
                                            @endif

                                            <span class="small text-truncate" style="max-width:130px;">
                                                {{ $doc['nombre'] }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Autorización</label>
                            <select class="form-select" wire:model.defer="autorizacion_estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="verbal">Verbal</option>
                                <option value="previa">Previa</option>
                                <option value="confianza">Confianza</option>
                                <option value="recibida">Recibida</option>
                                <option value="no_aplica">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Comentario de autorización</label>
                            <input type="text" class="form-control" wire:model.defer="autorizacion_comentario">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Anticipo</label>
                            <select class="form-select" wire:model.defer="anticipo_estado">
                                <option value="no_aplica">No aplica</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="solicitado">Solicitado</option>
                                <option value="recibido">Recibido</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Monto anticipo</label>
                            <input type="number" step="0.01" class="form-control"
                                wire:model.defer="anticipo_monto">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Aceptación</label>
                            <select class="form-select" wire:model.defer="aceptacion_estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="recibida">Recibida</option>
                                <option value="no_aplica">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Número de aceptación</label>
                            <input type="text" class="form-control" wire:model.defer="aceptacion_numero">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Factura</label>
                            <select class="form-select" wire:model.defer="factura_estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="emitida">Emitida</option>
                                <option value="enviada">Enviada</option>
                                <option value="no_aplica">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Número de factura</label>

                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.defer="factura_numero">

                                <button type="button" class="btn btn-outline-primary"
                                    wire:click="abrirModalInfo('factura')">
                                    <i class="fas fa-paperclip me-1"></i>
                                    Agregar info
                                </button>
                            </div>
                            @if (!empty($adminDocumentosResumen['factura']))
                                <div class="d-flex align-items-center flex-wrap gap-1 mt-1">
                                    @foreach ($adminDocumentosResumen['factura'] as $doc)
                                        <a href="{{ $doc['url'] }}" target="_blank"
                                            class="d-inline-flex align-items-center text-decoration-none border rounded px-1 py-1 bg-light"
                                            style="max-width: 180px;" title="{{ $doc['archivo_original'] }}">
                                            @if ($doc['es_imagen'])
                                                <img src="{{ $doc['url'] }}" class="rounded border me-1"
                                                    style="width:25px; height:25px; object-fit:cover;">
                                            @elseif ($doc['es_pdf'])
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file-pdf" style="font-size:13px;"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file" style="font-size:13px;"></i>
                                                </span>
                                            @endif

                                            <span class="small text-truncate" style="max-width:130px;">
                                                {{ $doc['nombre'] }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Contraseña de pago</label>
                            <select class="form-select" wire:model.defer="contrasena_pago_estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="recibida">Recibida</option>
                                <option value="no_aplica">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Número de contraseña</label>

                            <div class="input-group">
                                <input type="text" class="form-control" wire:model.defer="contrasena_pago_numero">

                                <button type="button" class="btn btn-outline-primary"
                                    wire:click="abrirModalInfo('contrasena_pago')">
                                    <i class="fas fa-paperclip me-1"></i>
                                    Agregar info
                                </button>
                            </div>
                            @if (!empty($adminDocumentosResumen['contrasena_pago']))
                                <div class="d-flex align-items-center flex-wrap gap-1 mt-1">
                                    @foreach ($adminDocumentosResumen['contrasena_pago'] as $doc)
                                        <a href="{{ $doc['url'] }}" target="_blank"
                                            class="d-inline-flex align-items-center text-decoration-none border rounded px-1 py-1 bg-light"
                                            style="max-width: 180px;" title="{{ $doc['archivo_original'] }}">
                                            @if ($doc['es_imagen'])
                                                <img src="{{ $doc['url'] }}" class="rounded border me-1"
                                                    style="width:25px; height:25px; object-fit:cover;">
                                            @elseif ($doc['es_pdf'])
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file-pdf" style="font-size:13px;"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file" style="font-size:13px;"></i>
                                                </span>
                                            @endif

                                            <span class="small text-truncate" style="max-width:130px;">
                                                {{ $doc['nombre'] }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Pago</label>
                            <select class="form-select" wire:model.defer="pago_estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="pagado">Pagado</option>
                                <option value="no_aplica">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Comprobante de pago</label>

                            <button type="button" class="btn btn-outline-primary w-100"
                                wire:click="abrirModalInfo('pago')">
                                <i class="fas fa-paperclip me-1"></i>
                                Agregar info de pago
                            </button>
                            @if (!empty($adminDocumentosResumen['pago']))
                                <div class="d-flex align-items-center flex-wrap gap-1 mt-1">
                                    @foreach ($adminDocumentosResumen['pago'] as $doc)
                                        <a href="{{ $doc['url'] }}" target="_blank"
                                            class="d-inline-flex align-items-center text-decoration-none border rounded px-1 py-1 bg-light"
                                            style="max-width: 180px;" title="{{ $doc['archivo_original'] }}">
                                            @if ($doc['es_imagen'])
                                                <img src="{{ $doc['url'] }}" class="rounded border me-1"
                                                    style="width:25px; height:25px; object-fit:cover;">
                                            @elseif ($doc['es_pdf'])
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file-pdf" style="font-size:13px;"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded me-1"
                                                    style="width:25px; height:25px;">
                                                    <i class="far fa-file" style="font-size:13px;"></i>
                                                </span>
                                            @endif

                                            <span class="small text-truncate" style="max-width:130px;">
                                                {{ $doc['nombre'] }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Comentarios administrativos</label>
                            <textarea class="form-control" rows="3" wire:model.defer="comentarios"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="button" class="btn btn-primary" wire:click="guardarAdminStatus"
                        wire:loading.attr="disabled" wire:target="guardarAdminStatus">
                        <span wire:loading.remove wire:target="guardarAdminStatus">
                            Guardar estado
                        </span>

                        <span wire:loading wire:target="guardarAdminStatus">
                            Guardando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="adminInfoModal" tabindex="-1"
        aria-labelledby="adminInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="adminInfoModalLabel">
                        Agregar info: {{ $infoTitulo }}
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    @error('infoFile')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <div id="adminInfoPasteZone" tabindex="0"
                        class="border rounded-3 p-4 text-center bg-light mb-3"
                        style="border-style: dashed !important;">

                        <div class="mb-2">
                            <i class="fas fa-paste fa-2x text-info"></i>
                        </div>

                        <h5 class="mb-1">Pegar captura aquí</h5>

                        <p class="text-muted mb-0">
                            Copie una captura de pantalla y presione <strong>Ctrl + V</strong> dentro de este cuadro.
                        </p>

                        @if ($infoPastedImageData)
                            <div class="mt-3 d-flex align-items-center justify-content-center">
                                <div class="d-flex align-items-center gap-2 border rounded p-2 bg-white shadow-sm">
                                    <img src="{{ $infoPastedImageData }}" class="rounded border"
                                        style="width: 64px; height: 64px; object-fit: cover;">

                                    <div class="small text-start">
                                        <div class="fw-semibold">
                                            Screenshot pegado
                                        </div>

                                        <div class="text-muted">
                                            Se guardará como imagen.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">O cargar archivo desde disco</label>

                        <input type="file" class="form-control" wire:model="infoFile"
                            accept="image/*,.pdf,application/pdf">

                        <div wire:loading wire:target="infoFile" class="text-primary small mt-2">
                            Cargando archivo...
                        </div>

                        <div class="form-text">
                            Formatos permitidos: JPG, PNG, WEBP o PDF. Máximo 10 MB.
                        </div>

                        @if ($infoFile)
                            <div class="mt-2">
                                @php
                                    $mimePreview = $infoFile->getMimeType();
                                    $fileNamePreview = $infoFile->getClientOriginalName();
                                @endphp

                                @if (str_starts_with($mimePreview, 'image/'))
                                    <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                                        <img src="{{ $infoFile->temporaryUrl() }}" class="rounded border"
                                            style="width: 52px; height: 52px; object-fit: cover;">

                                        <div class="small">
                                            <div class="fw-semibold">
                                                Imagen seleccionada
                                            </div>

                                            <div class="text-muted text-truncate" style="max-width: 320px;">
                                                {{ $fileNamePreview }}
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($mimePreview === 'application/pdf')
                                    <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                                        <div class="d-flex align-items-center justify-content-center rounded bg-danger text-white"
                                            style="width: 52px; height: 52px;">
                                            <i class="far fa-file-pdf fa-2x"></i>
                                        </div>

                                        <div class="small">
                                            <div class="fw-semibold">
                                                PDF seleccionado
                                            </div>

                                            <div class="text-muted text-truncate" style="max-width: 320px;">
                                                {{ $fileNamePreview }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comentario</label>
                        <textarea class="form-control" rows="2" wire:model.defer="infoComentario"
                            placeholder="Ejemplo: OC enviada por compras, captura de correo, comprobante de depósito, etc."></textarea>
                    </div>

                    <button type="button" class="btn btn-info text-white" wire:click="guardarInfoDocumento"
                        wire:loading.attr="disabled" wire:target="guardarInfoDocumento">
                        <span wire:loading.remove wire:target="guardarInfoDocumento">
                            Guardar evidencia
                        </span>

                        <span wire:loading wire:target="guardarInfoDocumento">
                            Guardando...
                        </span>
                    </button>

                    <hr>

                    <h6 class="mb-3">Evidencias guardadas</h6>

                    @if (!empty($infoDocumentos))
                        <div class="list-group">
                            @foreach ($infoDocumentos as $doc)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="fw-bold">
                                                @if ($doc['es_pdf'])
                                                    <i class="far fa-file-pdf text-danger me-1"></i>
                                                @else
                                                    <i class="far fa-image text-primary me-1"></i>
                                                @endif

                                                {{ $doc['archivo_original'] }}
                                            </div>

                                            <div class="small text-muted">
                                                Subido por {{ $doc['uploaded_by'] ?? 'N/A' }}
                                                · {{ $doc['created_at'] }}
                                            </div>

                                            @if ($doc['comentario'])
                                                <div class="small mt-1">
                                                    {{ $doc['comentario'] }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="text-end">
                                            <a href="{{ $doc['url'] }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                Ver
                                            </a>

                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                wire:click="eliminarInfoDocumento({{ $doc['id'] }})">
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>

                                    @if ($doc['es_imagen'])
                                        <div class="mt-3">
                                            <img src="{{ $doc['url'] }}" class="img-fluid rounded border"
                                                style="max-height: 180px;">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted">
                            Todavía no hay evidencias guardadas para esta sección.
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('livescripts')
        <script>
            window.addEventListener('abrir-modal-admin-status', function() {
                var modalEl = document.getElementById('adminStatusModal');
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            });

            window.addEventListener('cerrar-modal-admin-status', function() {
                var modalEl = document.getElementById('adminStatusModal');
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
            });

            window.addEventListener('admin-status-actualizado', function() {
                Swal.fire({
                    title: 'Estado actualizado',
                    text: 'El estado administrativo fue actualizado correctamente.',
                    icon: 'success'
                });
            });
        </script>
        <script>
            window.addEventListener('abrir-modal-admin-info', function() {
                var modalEl = document.getElementById('adminInfoModal');
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();

                setTimeout(function() {
                    var zone = document.getElementById('adminInfoPasteZone');
                    if (zone) {
                        zone.focus();
                    }
                }, 300);
            });

            window.addEventListener('admin-info-guardada', function() {
                Swal.fire({
                    title: 'Evidencia guardada',
                    text: 'La información fue guardada correctamente.',
                    icon: 'success'
                });
            });

            window.addEventListener('admin-info-eliminada', function() {
                Swal.fire({
                    title: 'Evidencia eliminada',
                    text: 'El archivo fue eliminado correctamente.',
                    icon: 'success'
                });
            });

            document.addEventListener('paste', function(event) {
                var modalEl = document.getElementById('adminInfoModal');

                if (!modalEl || !modalEl.classList.contains('show')) {
                    return;
                }

                var items = (event.clipboardData || event.originalEvent.clipboardData).items;

                if (!items) {
                    return;
                }

                for (var i = 0; i < items.length; i++) {
                    var item = items[i];

                    if (item.type.indexOf('image') === 0) {
                        var file = item.getAsFile();
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            @this.set('infoPastedImageData', e.target.result);
                        };

                        reader.readAsDataURL(file);

                        event.preventDefault();
                        break;
                    }
                }
            });
        </script>
    @endpush
</div>
