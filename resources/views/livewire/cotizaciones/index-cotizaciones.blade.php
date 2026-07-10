<div>
    <x-pretty-card>
        <h2>Listado General de Cotizaciones</h2>
        Revisa todas las cotizaciones creadas en el sistema.
    </x-pretty-card>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <x-pretty-card>
        <div class="d-flex align-items-center gap-2 mb-3">
            <a class="btn btn-outline-primary" href="{{ route('admin.cotizaciones.create') }}">
                <span class="fas fa-plus me-1"></span>
                Nueva Cotización
            </a>

            <button type="button" class="btn btn-outline-success" wire:click="unificarCotizaciones"
                wire:loading.attr="disabled" wire:target="unificarCotizaciones">

                <span wire:loading.remove wire:target="unificarCotizaciones">
                    <i class="fas fa-object-group me-1"></i>
                    Unificar cotizaciones

                    @if (count($cotizacionesSeleccionadas) > 0)
                        <span class="badge bg-success ms-1">
                            {{ count($cotizacionesSeleccionadas) }}
                        </span>
                    @endif
                </span>

                <span wire:loading wire:target="unificarCotizaciones">
                    Validando...
                </span>
            </button>
        </div>
    </x-pretty-card>

    <x-pretty-card>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>

                    <input type="search" class="form-control" placeholder="Buscar por cotización, cliente u OS..."
                        wire:model.debounce.300ms="search">

                    @if ($search)
                        <button type="button" class="btn btn-outline-secondary" wire:click="$set('search', '')">
                            Limpiar
                        </button>
                    @endif
                </div>

                <div class="form-text">
                    Ejemplos: Cem, 30, 26-030, COT26-0030, 2M25-0030
                </div>
            </div>

            <div class="col-md-6 text-end">
                <div wire:loading.delay wire:target="search" class="small text-muted pt-2">
                    Filtrando cotizaciones...
                </div>
            </div>
        </div>
    </x-pretty-card>

    <div class="card mb-3">
        <div class="card-body p-0">


            <div class="px-3 pt-3">
                {{ $cotizaciones->links() }}
            </div>

            <div class="table-responsive scrollbar">
                <table class="table table-hover table-striped overflow-hidden fs--1 mb-0" style="font-size: 0.75rem;"
                    wire:loading.remove>
                    <thead class="bg-300 text-dark">
                        <tr class="text-800">
                            <th style="width:3%; border:1px solid #000">
                                #
                            </th>

                            <th style="width:11%; cursor:pointer;" wire:click="sortBy('numero')">
                                Número
                            </th>

                            <th style="width:9%; cursor:pointer;" wire:click="sortBy('fecha_cotizacion')">
                                Fecha
                            </th>

                            <th style="width:18%;">
                                Cliente
                            </th>

                            <th style="width:11%;">
                                OS
                            </th>



                            <th style="width:20%;">
                                Título
                            </th>

                            <th style="width:8%;" class="text-center">
                                Versión
                            </th>

                            <th style="width:9%;" class="text-end">
                                Total
                            </th>

                            <th style="width:13%;" class="text-center">
                                Herramientas
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($cotizaciones as $cotizacion)
                            @php
                                $versiones = $this->versionesDe($cotizacion);
                            @endphp

                            <tr x-data="{ open: false }">
                                <td>
                                    <input type="checkbox" class="form-check-input" value="{{ $cotizacion->id }}"
                                        wire:model="cotizacionesSeleccionadas">
                                </td>

                                <td class="fw-bold">
                                    {{ $cotizacion->numero }}

                                    @if ($versiones->count() > 0)
                                        <button type="button" class="btn btn-link btn-sm p-0 ms-1"
                                            wire:click="toggleVersiones({{ $cotizacion->id }})" title="Ver versiones">
                                            <i class="fas fa-code-branch"></i>
                                        </button>
                                    @endif
                                </td>

                                <td>
                                    @if ($cotizacion->fecha_cotizacion)
                                        {{ $cotizacion->fecha_cotizacion->format('d/m/Y') }}
                                    @endif
                                </td>

                                <td>
                                    {{ optional($cotizacion->cliente)->cliente }}
                                </td>

                                <td>
                                    {{ $this->osCotizacion($cotizacion) }}

                                    @if ($cotizacion->motor && $this->potenciaCotizacion($cotizacion) !== '-')
                                        <div class="text-muted small" style="line-height: 1.1;">
                                            {{ $this->potenciaCotizacion($cotizacion) }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $cotizacion->titulo }}
                                    </div>

                                    @if ($cotizacion->subtitulo)
                                        <div class="text-muted small">
                                            {{ $cotizacion->subtitulo }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        V{{ $cotizacion->version }}
                                    </span>
                                </td>

                                <td class="text-end fw-bold">
                                    {{ $this->simboloMoneda($cotizacion->moneda) }}{{ number_format($cotizacion->total, 2) }}

                                    @if ($cotizacion->moneda === 'GTQ_USD')
                                        @php
                                            $totalUsd = $this->totalUsd($cotizacion);
                                        @endphp

                                        @if ($totalUsd)
                                            <div class="text-muted" style="font-size: 9px; line-height: 1;">
                                                USD ${{ number_format($totalUsd, 2) }}
                                            </div>
                                        @endif
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.cotizaciones.downloadPdf', ['cotizacion' => $cotizacion->id]) }}"
                                            class="btn btn-sm btn-outline-danger" target="_blank" title="Ver PDF">
                                            <i class="far fa-file-pdf"></i>
                                        </a>

                                        <a href="{{ route('admin.cotizaciones.edit', ['cotizacion' => $cotizacion->id]) }}"
                                            class="btn btn-sm btn-outline-primary" title="Editar cotización">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @if (!($cotizacion->es_unificada ?? false))
                                            <a href="{{ route('admin.cotizaciones.adicional', ['cotizacion' => $cotizacion->id]) }}"
                                                class="btn btn-sm btn-outline-warning" title="Agregar otra cotización">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-success"
                                            wire:click.prevent="abrirModalAdminCotizacion({{ $cotizacion->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="abrirModalAdminCotizacion({{ $cotizacion->id }})"
                                            title="Administrativo">
                                            <i class="fas fa-clipboard-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            wire:click="confirmarEliminarCotizacion({{ $cotizacion->id }})"
                                            wire:loading.attr="disabled" title="Eliminar cotización">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="{{ route('admin.cotizaciones.duplicar', ['cotizacion' => $cotizacion->id]) }}"
                                            class="btn btn-sm btn-outline-info" title="Duplicar cotización">
                                            <i class="far fa-copy"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @if ($cotizacion->motor && $cotizacion->motor->adminStatus && $cotizacion->motor->adminStatus->documentos->count() > 0)
                                <tr class="bg-light">
                                    <td></td>
                                    <td colspan="9" class="py-2">
                                        <div class="ms-4 ps-3 border-start border-3 border-success">
                                            <div class="d-flex align-items-center flex-wrap gap-2">
                                                <span class="text-muted small me-2">
                                                    <i class="fas fa-paperclip me-1"></i>
                                                    Evidencias administrativas:
                                                </span>

                                                @foreach ($cotizacion->motor->adminStatus->documentos as $documento)
                                                    <a href="{{ $documento->url }}" target="_blank"
                                                        class="badge rounded-pill border bg-white text-decoration-none px-3 py-2"
                                                        title="{{ $documento->archivo_original }}">
                                                        @if ($documento->es_pdf)
                                                            <i class="far fa-file-pdf text-danger me-1"></i>
                                                        @elseif ($documento->es_imagen)
                                                            <i class="far fa-image text-primary me-1"></i>
                                                        @else
                                                            <i class="far fa-file-alt text-secondary me-1"></i>
                                                        @endif

                                                        {{ ucfirst(str_replace('_', ' ', $documento->tipo)) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @php
                                $adicionales = $this->adicionalesDeCotizacion($cotizacion);
                            @endphp

                            @foreach ($adicionales as $adicional)
                                <tr class="table-warning">
                                    <td></td>

                                    <td colspan="2" style="padding-left: 45px;">
                                        <div class="fw-bold text-warning">
                                            <i class="fas fa-level-up-alt fa-rotate-90 me-1"></i>
                                            {{ $adicional->numero }}
                                        </div>

                                        <div class="small text-muted">
                                            Cotización adicional relacionada con {{ $cotizacion->numero }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ optional($adicional->cliente)->cliente }}
                                    </td>

                                    <td>
                                        @if ($adicional->motor)
                                            {{ $adicional->motor->year }}-{{ $adicional->motor->os }}
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($adicional->total, 2) }}
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.cotizaciones.downloadPdf', ['cotizacion' => $adicional->id]) }}"
                                                class="btn btn-sm btn-outline-danger" target="_blank"
                                                title="Ver PDF">
                                                <i class="far fa-file-pdf"></i>
                                            </a>

                                            <a href="{{ route('admin.cotizaciones.edit', ['cotizacion' => $adicional->id]) }}"
                                                class="btn btn-sm btn-outline-primary" title="Editar adicional">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <a href="{{ route('admin.cotizaciones.adicional', ['cotizacion' => $adicional->id]) }}"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Agregar otra cotización adicional">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                wire:click="confirmarEliminarCotizacion({{ $cotizacion->id }})"
                                                wire:loading.attr="disabled" title="Eliminar cotización">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <a href="{{ route('admin.cotizaciones.duplicar', ['cotizacion' => $adicional->id]) }}"
                                                class="btn btn-sm btn-outline-info" title="Duplicar adicional">
                                                <i class="far fa-copy"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($versiones->count() > 0)
                                @if ($this->versionesEstanAbiertas($cotizacion->id))
                                    <tr>
                                        <td colspan="10" class="bg-light p-0">
                                            <div class="p-3">
                                                <div class="fw-bold mb-2">
                                                    Versiones anteriores
                                                </div>

                                                <table class="table table-sm table-bordered mb-0 bg-white">
                                                    <thead>
                                                        <tr>
                                                            <th>Número</th>
                                                            <th>Fecha</th>
                                                            <th>OS</th>

                                                            <th>Título</th>
                                                            <th class="text-center">Versión</th>
                                                            <th class="text-end">Total</th>
                                                            <th class="text-center">Herramientas</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($versiones as $version)
                                                            <tr>
                                                                <td class="fw-bold">
                                                                    {{ $version->numero }}
                                                                </td>

                                                                <td>
                                                                    @if ($version->fecha_cotizacion)
                                                                        {{ $version->fecha_cotizacion->format('d/m/Y') }}
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    {{ $this->osCotizacion($version) }}

                                                                    @if ($cotizacion->motor && $this->potenciaCotizacion($cotizacion) !== '-')
                                                                        <div class="text-muted small"
                                                                            style="line-height: 1.1;">
                                                                            {{ $this->potenciaCotizacion($cotizacion) }}
                                                                        </div>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    {{ $version->titulo }}

                                                                    @if ($version->subtitulo)
                                                                        <div class="text-muted small">
                                                                            {{ $version->subtitulo }}
                                                                        </div>
                                                                    @endif
                                                                </td>

                                                                <td class="text-center">
                                                                    <span class="badge bg-secondary">
                                                                        V{{ $version->version }}
                                                                    </span>
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ $this->simboloMoneda($version->moneda) }}{{ number_format($version->total, 2) }}
                                                                </td>

                                                                <td class="text-center">
                                                                    <div class="btn-group">
                                                                        <a href="{{ route('admin.cotizaciones.downloadPdf', ['cotizacion' => $version->id]) }}"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            target="_blank" title="Ver PDF">
                                                                            <i class="far fa-file-pdf"></i>
                                                                        </a>

                                                                        <a href="{{ route('admin.cotizaciones.edit', ['cotizacion' => $version->id]) }}"
                                                                            class="btn btn-sm btn-outline-primary"
                                                                            title="Editar esta versión">
                                                                            <i class="far fa-edit"></i>
                                                                        </a>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            wire:click="confirmarEliminarVersion({{ $version->id }})"
                                                                            title="Eliminar esta versión">
                                                                            <i class="far fa-trash-alt"></i>
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            wire:click="confirmarEliminarCotizacion({{ $cotizacion->id }})"
                                                                            wire:loading.attr="disabled"
                                                                            title="Eliminar cotización">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No hay cotizaciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 py-3">
                {{ $cotizaciones->links() }}
            </div>
        </div>
    </div>
    @include('livewire.administracion.partials.admin-status-modal')
    @include('livewire.administracion.partials.admin-info-modal')
    <script>
        window.addEventListener('confirmar-eliminar-version-cotizacion', function(event) {
            const cotizacionId = event.detail.cotizacion_id;
            const numero = event.detail.numero;

            Swal.fire({
                title: '¿Eliminar versión?',
                html: 'Está por eliminar la versión <strong>' + numero +
                    '</strong>.<br>Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('eliminarVersionCotizacionConfirmada', cotizacionId);
                }
            });
        });

        window.addEventListener('swal-success', function(event) {
            Swal.fire({
                title: event.detail.title || 'Correcto',
                text: event.detail.text || '',
                icon: 'success',
                timer: 2200,
                showConfirmButton: false,
            });
        });

        window.addEventListener('swal-error', function(event) {
            Swal.fire({
                title: event.detail.title || 'Error',
                text: event.detail.text || '',
                icon: 'error',
            });
        });

        window.addEventListener('abrir-modal-admin-status', function() {
            var modalEl = document.getElementById('adminStatusModal');

            if (!modalEl) {
                console.error('No existe #adminStatusModal en esta vista.');
                return;
            }

            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });

        window.addEventListener('cerrar-modal-admin-status', function() {
            var modalEl = document.getElementById('adminStatusModal');

            if (!modalEl) {
                return;
            }

            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
        });

        window.addEventListener('abrir-modal-admin-info', function() {
            var modalEl = document.getElementById('adminInfoModal');

            if (!modalEl) {
                console.error('No existe #adminInfoModal en esta vista.');
                return;
            }

            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });

        window.addEventListener('admin-status-actualizado', function() {
            Swal.fire({
                title: 'Estado actualizado',
                text: 'El estado administrativo fue actualizado correctamente.',
                icon: 'success'
            });
        });

        window.addEventListener('admin-info-guardada', function() {
            Swal.fire({
                title: 'Evidencia guardada',
                text: 'La información fue guardada correctamente.',
                icon: 'success'
            });
        });

        window.addEventListener('swal-error', function(event) {
            Swal.fire({
                title: event.detail.title || 'Error',
                text: event.detail.text || 'No se pudo completar la acción.',
                icon: 'error'
            });
        });
    </script>
    <script>
        window.addEventListener('confirmar-eliminar-cotizacion', function(event) {
            Swal.fire({
                title: '¿Eliminar cotización?',
                html: 'Está por eliminar la cotización <strong>' + event.detail.numero +
                    '</strong>.<br><br>Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('eliminarCotizacion', event.detail.cotizacion_id);
                }
            });
        });

        window.addEventListener('cotizacion-eliminada', function(event) {
            Swal.fire({
                icon: 'success',
                title: 'Cotización eliminada',
                text: event.detail.message || 'La cotización fue eliminada correctamente.',
                timer: 1800,
                showConfirmButton: false
            });
        });

        window.addEventListener('swal-error', function(event) {
            Swal.fire({
                icon: 'error',
                title: event.detail.title || 'Error',
                text: event.detail.text || 'Ocurrió un error.',
            });
        });
    </script>
</div>
