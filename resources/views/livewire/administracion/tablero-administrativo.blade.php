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
   @include('livewire.administracion.partials.admin-status-modal')
@include('livewire.administracion.partials.admin-info-modal')

    

   
</div>
