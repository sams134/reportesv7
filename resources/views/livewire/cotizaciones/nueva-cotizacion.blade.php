<div>
    <style>
        .cotizacion-items-card,
        .cotizacion-items-card .card-body,
        .cotizacion-items-table-wrapper,
        .cotizacion-items-table-wrapper table,
        .cotizacion-items-table-wrapper tbody,
        .cotizacion-items-table-wrapper tr,
        .cotizacion-items-table-wrapper td {
            overflow: visible !important;
        }

        .cotizacion-items-card.items-search-open {
            min-height: 680px;
        }

        .cotizacion-items-card.items-search-open .card-body {
            min-height: 620px;
        }

        .cotizacion-items-table-wrapper.search-active {
            min-height: 560px;
        }
    </style>
    <style>
        .drag-handle {
            cursor: grab;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .sortable-ghost {
            opacity: 0.35;
        }

        .sortable-chosen {
            background-color: #f8f9fa;
        }
    </style>
    {{-- The best athlete wants his opponent at his best. --}}
    <x-pretty-card>
        <h2>
            {{ $modoEdicion ? 'Editar Cotización' : 'Nueva Cotización' }}
        </h2>

        @if ($modoEdicion)
            <div class="mt-2">
                <span class="badge bg-warning text-dark">
                    Editando {{ $numeroCotizacion }}
                </span>
            </div>
        @endif
        @if ($modoUnificacion)
            <div class="alert alert-success border mb-3">
                <div class="fw-bold mb-2">
                    Modo cotización unificada
                </div>

                <div class="small mb-2">
                    Está creando una cotización unificada a partir de las siguientes cotizaciones:
                </div>

                <ul class="mb-0">
                    @foreach ($cotizacionesOrigenResumen as $origen)
                        <li>
                            <strong>{{ $origen['numero'] }}</strong>
                            — {{ $origen['os'] }}
                            — {{ $origen['equipo'] }}
                            @if ($origen['potencia'])
                                — {{ $origen['potencia'] }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($modoAdicional)
            <div class="alert alert-warning border mb-3">
                <div class="fw-bold mb-1">
                    Modo cotización adicional
                </div>

                <div class="small">
                    Está creando una cotización adicional relacionada con:
                    <strong>{{ $cotizacionBaseAdicionalNumero }}</strong>.
                </div>

                @if ($numeroAdicionalPreview)
                    <div class="small mt-1">
                        Número estimado de la nueva cotización:
                        <strong>{{ $numeroAdicionalPreview }}</strong>
                    </div>
                @endif
            </div>
        @endif
    </x-pretty-card>


    <div class="card border-primary shadow-sm mb-3" x-data="{ open: true }">
        <!-- CABECERA -->
        <div class="card-header bg-light d-flex justify-content-between align-items-center" @click="open = !open"
            style="cursor: pointer;">
            <span class="fw-semibold">
                Datos de información de la empresa, dirección, contacto, telefonos, etc.
            </span>

            <!-- Icono flecha (puedes usar bootstrap icons, fontawesome, o texto) -->
            <span class="ms-2" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;">
                ▾
            </span>
        </div>

        <!-- CONTENIDO -->
        <div class="card-body" x-show="open" x-transition x-cloak>
            <div class="row align-items-start">

                <!-- Columna: LOGO -->
                <div class="col-md-4  mb-3 mb-md-0">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="img-fluid" style="max-height: 150px;">

                </div>

                <!-- Columna: TÍTULO + SUMMARY -->
                <div class="col-md-4 mb-3 mb-md-0">
                    &nbsp;
                </div>

                <!-- Columna: DATOS DE LA EMPRESA -->
                <div class="col-md-4 text-md-end text-start">

                    <input type="text" class="form-control form-control-lg mb-2"
                        placeholder="Oferta Presupuestaria o Definitiva." wire:model.defer="tituloCotizacion">

                    <input type="text" class="form-control" placeholder="Resumen del tipo de Cotización"
                        wire:model.defer="subtituloCotizacion">
                    <strong>Amir S.A</strong><br>
                    23 avenida 28-46 zona 5<br>
                    Guatemala, Guatemala 01005<br>
                    Guatemala<br>
                    Phone: 2331-1596<br>
                    www.cmeamir.com<br>
                    info@cmeamir.com<br>
                    Nit: 778261-6
                </div>
            </div>
        </div>
    </div>
    <div class="card border-primary shadow-sm mb-3" x-data="{ open: true }">
        <!-- CABECERA -->
        <div class="card-header bg-light d-flex justify-content-between align-items-center" @click="open = !open"
            style="cursor: pointer;">
            <span class="fw-semibold">
                Datos de información de la empresa, dirección, contacto, telefonos, etc.
            </span>

            <!-- Icono flecha (puedes usar bootstrap icons, fontawesome, o texto) -->
            <span class="ms-2" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;">
                ▾
            </span>
        </div>

        <!-- CONTENIDO -->
        <div class="card-body" x-show="open" x-transition x-cloak>
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0" x-data="{
                    loadingContactos: false,
                    contactosListos: false,
                    sinContactos: false
                }"
                    @contactos-cargados.window="
        loadingContactos = false;
        sinContactos = ($event.detail.contactos.length === 0);
        contactosListos = ($event.detail.contactos.length > 0);
    ">
                    <p class="mb-1">Seleccione el Cliente</p>

                    <select class="form-select form-select-lg mb-1" wire:model="cliente_id"
                        @change="
            loadingContactos = true;
            contactosListos = false;
            sinContactos = false;
        ">
                        <option value="">Seleccione un Cliente</option>

                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}">
                                {{ $cliente->cliente }}
                            </option>
                        @endforeach
                    </select>

                    <a href="{{ $cliente_id ? route('clientes.edit', $cliente_id) : '#' }}"
                        class="d-inline-block small text-primary text-decoration-none mb-2"
                        style="{{ $cliente_id ? '' : 'visibility: hidden;' }}">
                        Editar Información de Cliente
                    </a>

                    {{-- LOADING --}}
                    <div x-show="loadingContactos" x-transition class="mt-2 text-center">
                        <img src="{{ asset('img/loading.gif') }}" alt="Cargando contactos..." style="width: 45px;">

                        <div class="small text-muted mt-1">
                            Cargando contactos...
                        </div>
                    </div>

                    {{-- SIN CONTACTOS --}}
                    <div x-show="sinContactos" x-transition class="alert alert-warning py-2 mt-2 mb-0">
                        Este cliente no tiene contactos registrados.
                    </div>

                    {{-- SELECT MULTIPLE --}}
                    <div x-show="contactosListos" x-transition wire:ignore wire:key="contactos-choices-wrapper"
                        class="mt-2">
                        <label class="form-label" for="contactosMultiple">
                            Contactos
                        </label>

                        <select class="form-select" id="contactosMultiple" multiple></select>
                    </div>

                    {{-- BLOQUE DINÁMICO DE DESTINATARIOS --}}
                    @if ($cliente_id)
                        <div class="mt-3 border rounded p-3 bg-light">
                            <p class="mb-0">Señores</p>

                            <p class="fw-bold mb-0">
                                {{ $clientePreview['cliente'] }}
                            </p>

                            @if (count($contactosPreview) > 0)
                                <p class="mb-1">
                                    @foreach ($contactosPreview as $contacto)
                                        {{ $contacto['contacto'] }}

                                        @if ($contacto['email'])
                                            [{{ $contacto['email'] }}]
                                        @else
                                            <span class="text-danger">[Sin email]</span>
                                        @endif

                                        @if (!$loop->last)
                                            /
                                        @endif
                                    @endforeach
                                </p>
                            @else
                                <p class="text-muted mb-1">
                                    Seleccione uno o más contactos.
                                </p>
                            @endif

                            <p class="mb-0">
                                {{ $clientePreview['razon_social'] }}
                            </p>

                            <p class="mb-0">
                                {{ $clientePreview['direccion_fiscal'] }}
                            </p>

                            <p class="mb-0">
                                {{ $clientePreview['pais'] }}
                            </p>

                            <p class="mb-0">
                                Nit: {{ $clientePreview['nit'] }}
                            </p>
                        </div>
                    @endif
                </div>



                <div class="col-md-4 mb-3 mb-md-0">
                    &nbsp;
                </div>

                <div class="col-md-4 text-md-end text-start">
                    <div class="mb-3 row">
                        <div class="col-xl-4 text-end">
                            <label class="form-label">
                                Numero Cotización
                            </label>
                        </div>

                        <div class="col-xl-8">
                            <input class="form-control fw-bold" type="text" wire:model="numeroCotizacion" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-xl-4 text-end">
                            <label class="form-label" for="exampleFormControlInput1">Fecha Cotización</label>
                        </div>
                        <div class="col-xl-8">
                            <input class="form-control datetimepicker" type="text" wire:model="cotDate"
                                data-options='{"disableMobile":true,"dateFormat": "d-m-Y"}' />
                        </div>

                    </div>
                    <div class="mb-3 row">
                        <div class="col-xl-4 text-end">
                            <label class="form-label" for="exampleFormControlInput1">Fecha Válida Hasta</label>
                        </div>
                        <div class="col-xl-8">
                            <input class="form-control datetimepicker" type="text" wire:model="cotValid"
                                data-options='{"disableMobile":true,"dateFormat": "d-m-Y"}' />
                        </div>

                    </div>
                    <div class="mb-3 row">
                        <div class="col-xl-4 text-end">
                            <label class="form-label">
                                OS / Equipo
                            </label>
                        </div>

                        <div class="col-xl-8">
                            @livewire('cotizaciones.search-os-cotizacion', [
                                'cliente_id' => $cliente_id,
                            ])
                            @if ($osSeleccionadaLabel)
                                <div class="small text-muted mt-1">
                                    OS seleccionada:
                                    <strong>{{ $osSeleccionadaLabel }}</strong>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($motorPreview)
            <style>
                .table-striped td:nth-child(odd),
                .table-striped th:nth-child(odd) {

                    font-weight: bold;
                }

                .table-datos td {
                    height: 20px;
                    padding: 5px;
                    font-size: 12px;
                }
            </style>
            <div class="card border-primary shadow-sm mb-3" x-data="{ open: true }">
                {{-- CABECERA --}}
                <div class="card-header bg-light d-flex justify-content-between align-items-center"
                    @click="open = !open" style="cursor: pointer;">
                    <span class="fw-semibold">
                        Datos del equipo
                    </span>

                    <span class="ms-2" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;">
                        ▾
                    </span>
                </div>

                {{-- CONTENIDO --}}
                <div class="card-body" x-show="open" x-transition x-cloak>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="usarDatosEquipoSwitch"
                            wire:model="usarDatosEquipo">

                        <label class="form-check-label" for="usarDatosEquipoSwitch">
                            Usar datos del equipo
                        </label>


                    </div>

                    @if ($usarDatosEquipo)
                        <div class="table-responsive scrollbar">
                            <table class="table table-hover table-striped table-bordered table-datos">
                                <tr>
                                    <td>Orden de Servicio</td>
                                    <td colspan="5">
                                        <strong>{{ $motorPreview['fullos'] }}</strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Nombre del Equipo</td>
                                    <td colspan="5">
                                        {{ $motorPreview['nombre_equipo'] ?: '' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Marca</td>
                                    <td>{{ $motorPreview['marca'] }}</td>

                                    <td>Serie</td>
                                    <td>{{ $motorPreview['serie'] }}</td>

                                    <td>Modelo</td>
                                    <td>{{ $motorPreview['modelo'] }}</td>
                                </tr>

                                <tr>
                                    <td>Potencia</td>
                                    <td>
                                        @if (isset($motorPreview['reales']) &&
                                                $motorPreview['reales'] !== null &&
                                                (int) $motorPreview['reales'] === 0 &&
                                                $motorPreview['potencia']
                                        )
                                            Aproximadamente {{ $motorPreview['potencia'] }}
                                        @else
                                            {{ $motorPreview['potencia'] }}
                                        @endif
                                    </td>

                                    <td>Volts</td>
                                    <td>{{ $motorPreview['volts'] }}</td>

                                    <td>Amps</td>
                                    <td>{{ $motorPreview['amps'] }}</td>
                                </tr>

                                <tr>
                                    <td>RPM</td>
                                    <td>{{ $motorPreview['rpm'] }}</td>

                                    <td>Factor Potencia</td>
                                    <td>{{ $motorPreview['pf'] }}</td>

                                    <td>Eficiencia</td>
                                    <td>{{ $motorPreview['eff'] }}</td>
                                </tr>

                                <tr>
                                    <td>HZ</td>
                                    <td>{{ $motorPreview['hz'] }}</td>

                                    <td>Frame</td>
                                    <td>{{ $motorPreview['frame'] }}</td>

                                    <td>Fases</td>
                                    <td>{{ $motorPreview['phases'] }}</td>
                                </tr>

                                <tr>
                                    <td colspan="1">Recibido por:</td>
                                    <td colspan="5">{{ $motorPreview['recibido'] }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2">Comentarios de Cliente</td>
                                    <td colspan="4">{{ $motorPreview['comentarios'] }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">
                                Resumen del equipo
                            </label>

                            <textarea class="form-control" rows="4" wire:model.defer="resumenEquipo"></textarea>

                            <div class="form-text">
                                Este texto se puede editar manualmente para ajustar la descripción en la cotización.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <div class="card border-primary shadow-sm mb-3" x-data="cotizacionPresentacionLoader()"
        @texto-presentacion-cargado.window="finalizarCargaPresentacion()">

        {{-- CABECERA --}}
        <div class="card-header bg-light d-flex justify-content-between align-items-center" @click="open = !open"
            style="cursor: pointer;">
            <span class="fw-semibold">
                Texto de presentación
            </span>

            <span class="ms-2" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;">
                ▾
            </span>
        </div>

        {{-- CONTENIDO --}}
        <div class="card border-primary shadow-sm mb-3" x-data="cotizacionPresentacionLoader()"
            @texto-presentacion-cargado.window="finalizarCargaPresentacion()">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        Tipo de presentación
                    </label>

                    <select class="form-select" wire:model="presentacion_id" @change="iniciarCargaPresentacion()">
                        <option value="">Seleccione un texto</option>

                        @foreach ($presentaciones as $presentacion)
                            <option value="{{ $presentacion->id }}">
                                {{ $presentacion->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label">
                        Texto a colocar en la cotización
                    </label>

                    <div class="position-relative">

                        <div wire:ignore>
                            <textarea id="textoPresentacionEditor" class="form-control" rows="8">{!! $textoPresentacion !!}</textarea>
                        </div>

                        <div x-show.important="loadingPresentacion" x-transition.opacity
                            style="display: none; z-index: 20; background: rgba(255,255,255,0.94); border: 1px solid #d8e0ea; border-radius: 6px;"
                            class="position-absolute top-0 start-0 w-100 h-100">

                            <div style="height: 100%; width: 100%; display: table;">
                                <div style="display: table-cell; vertical-align: middle; text-align: center;">
                                    <div style="width: 80%; max-width: 460px; margin: 0 auto;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="fw-semibold text-primary">
                                                Cargando texto de presentación...
                                            </div>

                                            <div class="small text-muted">
                                                <span x-text="progressPresentacion"></span>%
                                            </div>
                                        </div>

                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" :style="'width: ' + progressPresentacion + '%'">
                                            </div>
                                        </div>

                                        <div class="text-center small text-muted mt-2">
                                            Preparando contenido para el editor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-text">
                        Este texto será utilizado en el PDF de la cotización. Puede editarlo antes de guardar.
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!$modoUnificacion)
        <div id="cardItemsCotizacion" class="card border-primary shadow-sm mb-3 cotizacion-items-card">
            {{-- CABECERA --}}
            <div class="card-header bg-light d-flex justify-content-between align-items-center"
                onclick="scrollItemsCotizacionTop()" style="cursor: pointer;">
                <span class="fw-semibold">
                    Detalle de trabajos y materiales
                </span>

                <span class="ms-2" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;">
                    ▾
                </span>
            </div>

            {{-- CONTENIDO --}}
            <div class="card-body p-0">
                <div id="tablaItemsCotizacionWrapper"
                    class="table-responsive scrollbar cotizacion-items-table-wrapper">
                    <table class="table table-hover table-striped overflow-hidden mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 55%;">Producto</th>
                                <th class="text-center" style="width: 12%;">Cantidad</th>
                                <th class="text-end" style="width: 15%;">Precio Unitario</th>
                                <th class="text-end" style="width: 18%;">Precio Total</th>
                            </tr>
                        </thead>

                        <tbody id="itemsCotizacionSortable">
                            @foreach ($itemsCotizacion as $index => $item)
                                <tr wire:key="item-cotizacion-{{ $item['uid'] }}" data-uid="{{ $item['uid'] }}">
                                    <td>
                                        <div class="d-flex align-items-start mb-2">
                                            {{-- HANDLE PARA ARRASTRAR --}}
                                            <span class="btn btn-link text-600 p-1 me-2 drag-handle"
                                                title="Arrastrar para ordenar">
                                                <i class="fas fa-grip-vertical"></i>
                                            </span>

                                            {{-- NOMBRE DEL ITEM --}}
                                            <input type="text" class="form-control fw-bold"
                                                wire:model.defer="itemsCotizacion.{{ $index }}.nombre">

                                            {{-- ELIMINAR ITEM --}}
                                            <button type="button" class="btn btn-link text-danger ms-2"
                                                wire:click="eliminarItemCotizacion({{ $index }})"
                                                title="Eliminar item">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        {{-- DESCRIPCIÓN --}}
                                        <textarea class="form-control" rows="3" wire:model.defer="itemsCotizacion.{{ $index }}.descripcion"></textarea>
                                    </td>

                                    <td class="align-top">
                                        <input type="number" step="1" min="0"
                                            class="form-control text-center"
                                            wire:model.lazy="itemsCotizacion.{{ $index }}.cantidad">
                                    </td>

                                    <td class="align-top">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">
                                                {{ $this->simboloMoneda() }}
                                            </span>

                                            <input type="number" step="0.01" class="form-control text-end"
                                                wire:model.lazy="itemsCotizacion.{{ $index }}.precio_unitario"
                                                {{ ($item['tipo_item'] ?? null) === 'descuento' ? 'readonly' : '' }}>
                                        </div>

                                        @if ($this->mostrarConversionUsd())
                                            <div class="text-muted text-end mt-1"
                                                style="font-size: 9px; line-height: 1;">
                                                USD
                                                ${{ number_format($this->convertirAUsd($item['precio_unitario'] ?? 0), 2) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td
                                        class="align-top text-end fw-semibold {{ ($item['tipo_item'] ?? null) === 'descuento' ? 'text-danger' : '' }}">
                                        @if (($item['tipo_item'] ?? null) === 'descuento')
                                            -{{ $this->simboloMoneda() }}{{ number_format(abs($item['precio_total'] ?? 0), 2) }}
                                        @else
                                            {{ $this->simboloMoneda() }}{{ number_format($item['precio_total'] ?? 0, 2) }}
                                        @endif

                                        @if ($this->mostrarConversionUsd())
                                            <div class="text-muted mt-1" style="font-size: 9px; line-height: 1;">
                                                USD
                                                ${{ number_format(abs($this->convertirAUsd($item['precio_total'] ?? 0)), 2) }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                        <tbody>
                            {{-- FILA AGREGAR ITEM --}}
                            <tr>
                                <td colspan="4">
                                    @livewire('cotizaciones.search-item-cotizacion', key('search-item-cotizacion'))
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">
                                    Total
                                </td>

                                <td class="text-end fw-bold">
                                    {{ $this->simboloMoneda() }}{{ number_format($subtotalItems, 2) }}

                                    @if ($this->mostrarConversionUsd())
                                        <div class="text-muted mt-1" style="font-size: 10px; line-height: 1;">
                                            USD ${{ number_format($this->convertirAUsd($subtotalItems), 2) }}
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"></td>

                                <td colspan="2">
                                    <div class="row justify-content-end">
                                        <div class="col-xl-8 col-lg-10 col-md-12">
                                            <label class="form-label small mb-1">
                                                Moneda
                                            </label>

                                            <select class="form-select form-select-sm" wire:model="monedaCotizacion">
                                                <option value="GTQ">Q. Quetzales</option>
                                                <option value="USD">USD $ Dólares</option>
                                                <option value="GTQ_USD">Manejar Quetzales y Convertir a Dólares
                                                </option>
                                            </select>

                                            @if ($monedaCotizacion === 'GTQ_USD')
                                                <div class="mt-2">
                                                    <label class="form-label small mb-1">
                                                        Tipo de cambio Q x 1 USD
                                                    </label>

                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Q</span>

                                                        <input type="number" step="0.0001" min="0"
                                                            class="form-control text-end"
                                                            wire:model.lazy="tipoCambio">

                                                        <span class="input-group-text">x 1 USD</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if ($modoUnificacion)
        <div class="card border-success shadow-sm mb-3">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Ítems agrupados por OS / cotización</h5>
                    <div class="small text-muted">
                        Cada grupo corresponde a una cotización origen.
                    </div>
                </div>

                <div class="text-end">
                    <div class="small text-muted">Total unificado</div>
                    <div class="fw-bold fs-5">
                        {{ $monedaCotizacion === 'USD' ? '$' : 'Q' }}
                        {{ number_format($totalUnificado, 2) }}
                    </div>
                </div>
            </div>

            <div class="card-body">
                @foreach ($gruposUnificados as $grupoIndex => $grupo)
                    <div class="border rounded mb-4 overflow-hidden">
                        <div class="bg-success text-white px-3 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">
                                    {{ $grupo['numero'] }} — {{ $grupo['os'] }}
                                </div>

                                <div class="small">
                                    {{ $grupo['equipo'] }}
                                    @if (!empty($grupo['potencia']))
                                        — {{ $grupo['potencia'] }}
                                    @endif
                                </div>
                            </div>

                            <div class="text-end">
                                <div class="small">Subtotal</div>
                                <div class="fw-bold">
                                    {{ $monedaCotizacion === 'USD' ? '$' : 'Q' }}
                                    {{ number_format((float) $grupo['subtotal'], 2) }}
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 4%;">#</th>
                                        <th style="width: 24%;">Nombre</th>
                                        <th>Descripción</th>
                                        <th style="width: 9%;" class="text-end">Cantidad</th>
                                        <th style="width: 13%;" class="text-end">Precio Unit.</th>
                                        <th style="width: 13%;" class="text-end">Total</th>
                                        <th style="width: 6%;" class="text-center">Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($grupo['items'] as $itemIndex => $item)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model.defer="gruposUnificados.{{ $grupoIndex }}.items.{{ $itemIndex }}.nombre">
                                            </td>

                                            <td>
                                                <textarea class="form-control form-control-sm" rows="2"
                                                    wire:model.defer="gruposUnificados.{{ $grupoIndex }}.items.{{ $itemIndex }}.descripcion"></textarea>
                                            </td>

                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                    class="form-control form-control-sm text-end"
                                                    wire:model.defer="gruposUnificados.{{ $grupoIndex }}.items.{{ $itemIndex }}.cantidad"
                                                    wire:change="recalcularItemUnificado({{ $grupoIndex }}, {{ $itemIndex }})">
                                            </td>

                                            <td>
                                                <input type="number" step="0.01"
                                                    class="form-control form-control-sm text-end"
                                                    wire:model.defer="gruposUnificados.{{ $grupoIndex }}.items.{{ $itemIndex }}.precio_unitario"
                                                    wire:change="recalcularItemUnificado({{ $grupoIndex }}, {{ $itemIndex }})">
                                            </td>

                                            <td class="text-end fw-bold">
                                                {{ $monedaCotizacion === 'USD' ? '$' : 'Q' }}
                                                {{ number_format((float) ($item['precio_total'] ?? 0), 2) }}
                                            </td>

                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    wire:click="eliminarItemUnificado({{ $grupoIndex }}, {{ $itemIndex }})">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">
                                                Esta cotización no tiene ítems.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="5" class="text-end fw-bold">
                                            Subtotal {{ $grupo['os'] }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            {{ $monedaCotizacion === 'USD' ? '$' : 'Q' }}
                                            {{ number_format((float) $grupo['subtotal'], 2) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="p-2 bg-light text-end">
                            <button type="button" class="btn btn-sm btn-outline-success"
                                wire:click="agregarItemUnificado({{ $grupoIndex }})">
                                <i class="fas fa-plus me-1"></i>
                                Agregar ítem a {{ $grupo['os'] }}
                            </button>
                        </div>
                    </div>
                @endforeach

                <div class="border rounded p-3 bg-light d-flex justify-content-end align-items-center">
                    <div class="me-3 text-muted">
                        Total general cotización unificada:
                    </div>

                    <div class="fs-4 fw-bold text-success">
                        {{ $monedaCotizacion === 'USD' ? '$' : 'Q' }}
                        {{ number_format($totalUnificado, 2) }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card border-primary shadow-sm mb-3" x-data="{ open: true }">
        <div class="card-header bg-light d-flex justify-content-between align-items-center" @click="open = !open"
            style="cursor: pointer;">
            <span class="fw-semibold">
                Información adicional de la cotización
            </span>

            <span class="ms-2" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;">
                ▾
            </span>
        </div>

        <div class="card-body" x-show="open" x-transition x-cloak>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Qué no incluye</h5>

                    <button type="button" class="btn btn-sm btn-outline-primary" wire:click="abrirModalNoIncluye">
                        <i class="fas fa-plus-circle me-1"></i>
                        Agregar exclusiones
                    </button>
                </div>

                @if (count($noIncluyeItems) > 0)
                    <ul class="list-group">
                        @foreach ($noIncluyeItems as $index => $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $item }}</span>

                                <button type="button" class="btn btn-link text-danger p-0"
                                    wire:click="eliminarNoIncluye({{ $index }})">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-light border mb-0">
                        No se han agregado exclusiones.
                    </div>
                @endif
            </div>

            <hr>

            <div class="mb-4">
                <h5>Tiempo de entrega</h5>

                <div class="row">
                    <div class="col-md-6">
                        <select class="form-select" wire:model="tiempoEntrega">
                            <option value="">Seleccione tiempo de entrega</option>
                            <option value="inmediata">Disponibilidad inmediata</option>
                            <option value="24_horas">24 horas o menos</option>
                            <option value="1_2_dias">1-2 días hábiles</option>
                            <option value="2_3_dias">2-3 días hábiles</option>
                            <option value="3_4_dias">3-4 días hábiles</option>
                            <option value="4_5_dias">4-5 días hábiles</option>
                            <option value="5_7_dias">5-7 días hábiles</option>
                            <option value="a_convenir">A convenir con el cliente</option>
                            <option value="otro">Otro</option>
                        </select>

                        @error('tiempoEntrega')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    @if ($tiempoEntrega === 'otro')
                        <div class="col-md-6">
                            <input type="text" class="form-control" wire:model.defer="tiempoEntregaOtro"
                                placeholder="Ingrese tiempo aproximado de entrega">

                            @error('tiempoEntregaOtro')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>

            <hr>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Garantía</h5>

                    <button type="button" class="btn btn-sm btn-outline-primary"
                        wire:click="abrirModalGarantiaCotizacion">
                        Configurar garantía
                    </button>
                </div>

                <div class="alert alert-light border mb-0">
                    @if ($garantiaModo === 'general')
                        <strong>Garantía general:</strong>

                        @if ($garantiaGeneralActiva)
                            {{ $this->labelGarantiaTiempo($garantiaGeneralTiempo) }}
                        @else
                            Sin garantía general
                        @endif
                    @else
                        <strong>Garantía separada:</strong>
                        eléctricos {{ $this->labelGarantiaTiempo($garantiaElectricaTiempo) }},
                        mecánicos {{ $this->labelGarantiaTiempo($garantiaMecanicaTiempo) }}
                    @endif

                    <br>

                    <strong>Página final de términos y garantías:</strong>
                    {{ $incluirTerminosGarantias ? 'Sí' : 'No' }}
                </div>
            </div>

            <hr>

            <div class="mb-4">
                <h5>Términos de pago</h5>

                <div class="row">
                    <div class="col-md-6">
                        <select class="form-select" wire:model="terminosPago">
                            <option value="">Seleccione términos de pago</option>
                            <option value="100_anticipado">100% Anticipado</option>
                            <option value="50_50_entrega">50% Anticipo, 50% contra entrega</option>
                            <option value="50_50_30_credito">50% Anticipo, 50% 30 días crédito</option>
                            <option value="100_contra_entrega">100% Contra entrega</option>
                            <option value="15_credito">15 días crédito</option>
                            <option value="30_credito">30 días crédito</option>
                            <option value="45_credito">45 días crédito</option>
                            <option value="60_credito">60 días crédito</option>
                        </select>

                        @error('terminosPago')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="clienteDebeProveerOcSwitch"
                                wire:model="clienteDebeProveerOc">

                            <label class="form-check-label" for="clienteDebeProveerOcSwitch">
                                Cliente debe proveer OC para iniciar trabajos
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div>
                <h5>Notas adicionales</h5>

                <div wire:ignore>
                    <textarea id="notasAdicionalesCotizacionEditor" class="form-control" rows="7">{!! $notasAdicionales !!}</textarea>
                </div>

                <div class="form-text">
                    Puede agregar condiciones especiales, aclaraciones o consideraciones técnicas de esta cotización.
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mb-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                Revise los campos requeridos antes de guardar la cotización.
            </div>
        @endif
        <button class="btn btn-primary" type="button" wire:click="guardarCotizacion" wire:loading.attr="disabled"
            wire:target="guardarCotizacion">

            <span wire:loading.remove wire:target="guardarCotizacion">
                Guardar Cotización
            </span>

            <span wire:loading wire:target="guardarCotizacion">
                Guardando...
            </span>
        </button>

        <button class="btn btn-danger ms-2" type="button" wire:click="abrirModalOpcionesPdf"
            wire:loading.attr="disabled" wire:target="abrirModalOpcionesPdf">

            <span wire:loading.remove wire:target="abrirModalOpcionesPdf">
                <i class="far fa-file-pdf me-1"></i>
                Guardar Cotización y generar PDF
            </span>

            <span wire:loading wire:target="abrirModalOpcionesPdf">
                Preparando...
            </span>
        </button>
    </div>


    {{-- modals --}}
    <div wire:ignore.self class="modal fade" id="editarContactoCotizacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1"><button
                        class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" type="button"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1">Completar información del contacto </h4>
                        <p class="mb-0 small text-muted">Este contacto no tiene email registrado. Agregue el email para
                            usarlo en la cotización. </p>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="mb-3"><label class="form-label">Nombre del Contacto</label><input
                                class="form-control" type="text" wire:model.defer="contactoEditNombre">
                            @error('contactoEditNombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3"><label class="form-label">Puesto</label><input class="form-control"
                                type="text" wire:model.defer="contactoEditPuesto">
                            @error('contactoEditPuesto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3"><label class="form-label">Teléfono</label><input class="form-control"
                                type="text" wire:model.defer="contactoEditTelefono">
                            @error('contactoEditTelefono')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3"><label class="form-label">Email</label><input class="form-control"
                                type="email" wire:model.defer="contactoEditEmail">
                            @error('contactoEditEmail')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">Cerrar </button><button class="btn btn-primary" type="button"
                        wire:click="guardarContactoCotizacion" wire:loading.attr="disabled"
                        wire:target="guardarContactoCotizacion">Guardar contacto </button></div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="itemCotizacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" type="button"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1">
                            Agregar item a la cotización
                        </h4>

                        <p class="mb-0 small text-muted">
                            Los cambios aplican únicamente para esta cotización.
                        </p>
                    </div>

                    <div class="p-4 pb-0">

                        @if ($modalItemTipo === 'rebobinado')
                            <div class="alert alert-info py-2">
                                Complete o ajuste los datos técnicos para generar la descripción del rebobinado.
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Potencia HP</label>
                                    <input type="number" step="0.01" min="0" class="form-control"
                                        wire:model.lazy="rebobinadoHp">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Número de polos</label>
                                    <input type="number" step="2" min="2" class="form-control"
                                        wire:model.lazy="rebobinadoPolos">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Libras alambre aprox.</label>
                                    <input type="number" step="0.01" min="0" class="form-control"
                                        wire:model.lazy="rebobinadoLibrasAlambre">
                                </div>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="rebobinadoInverterDutySwitch"
                                    wire:model="rebobinadoInverterDuty">

                                <label class="form-check-label" for="rebobinadoInverterDutySwitch">
                                    Inverter Duty
                                </label>
                            </div>

                            <hr>
                            <div class="mb-3">
                                <label class="form-label d-block">
                                    Alcance del equipo
                                </label>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="solo_estator"
                                                wire:model="rebobinadoTipoServicio" id="rebSoloEstator">
                                            <label class="form-check-label" for="rebSoloEstator">Solo estator</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_completo"
                                                wire:model="rebobinadoTipoServicio" id="rebMotorCompleto">
                                            <label class="form-check-label" for="rebMotorCompleto">Motor
                                                completo</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_reductora"
                                                wire:model="rebobinadoTipoServicio" id="rebMotorReductora">
                                            <label class="form-check-label" for="rebMotorReductora">Motor + caja
                                                reductora</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_bomba"
                                                wire:model="rebobinadoTipoServicio" id="rebMotorBomba">
                                            <label class="form-check-label" for="rebMotorBomba">Motor + bomba</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_ventilador"
                                                wire:model="rebobinadoTipoServicio" id="rebMotorVentilador">
                                            <label class="form-check-label" for="rebMotorVentilador">Motor +
                                                ventilador / aspa</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_maquina"
                                                wire:model="rebobinadoTipoServicio" id="rebMotorMaquina">
                                            <label class="form-check-label" for="rebMotorMaquina">Motor +
                                                máquina</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Nombre del item</label>

                            <input type="text" class="form-control" wire:model.defer="modalItemNombre">

                            @error('modalItemNombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>

                            <textarea class="form-control" rows="{{ $modalItemTipo === 'rebobinado' ? 9 : 5 }}"
                                wire:model.defer="modalItemDescripcion"></textarea>

                            @error('modalItemDescripcion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if ($modalItemTipo === 'rebobinado')
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Precio rebobinado base
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="modalItemPrecioUnitario">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Costos adicionales
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="rebobinadoCostoAdicional">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Costo pruebas
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="rebobinadoCostoPruebas">
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border py-2">
                                <div class="d-flex justify-content-between">
                                    <span>Total rebobinado:</span>
                                    <strong>{{ $this->simboloMoneda() }}{{ number_format($this->totalRebobinadoModal(), 2) }}</strong>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span>Item automático de pruebas:</span>
                                    <strong>{{ $this->simboloMoneda() }}{{ number_format((float) $rebobinadoCostoPruebas, 2) }}</strong>
                                </div>
                            </div>
                        @endif
                        @if ($modalItemTipo === 'mantenimiento')
                            <div class="alert alert-info py-2">
                                Complete o ajuste los datos técnicos para generar la descripción del mantenimiento.
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">
                                    Alcance del equipo
                                </label>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="solo_estator"
                                                wire:model="mantenimientoTipoServicio" id="mantSoloEstator">
                                            <label class="form-check-label" for="mantSoloEstator">Solo estator</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_completo"
                                                wire:model="mantenimientoTipoServicio" id="mantMotorCompleto">
                                            <label class="form-check-label" for="mantMotorCompleto">Motor
                                                completo</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_reductora"
                                                wire:model="mantenimientoTipoServicio" id="mantMotorReductora">
                                            <label class="form-check-label" for="mantMotorReductora">Motor + caja
                                                reductora</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_bomba"
                                                wire:model="mantenimientoTipoServicio" id="mantMotorBomba">
                                            <label class="form-check-label" for="mantMotorBomba">Motor + bomba</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_ventilador"
                                                wire:model="mantenimientoTipoServicio" id="mantMotorVentilador">
                                            <label class="form-check-label" for="mantMotorVentilador">Motor +
                                                ventilador / aspa</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="motor_maquina"
                                                wire:model="mantenimientoTipoServicio" id="mantMotorMaquina">
                                            <label class="form-check-label" for="mantMotorMaquina">Motor +
                                                máquina</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Potencia HP</label>
                                    <input type="number" step="0.01" min="0" class="form-control"
                                        wire:model.lazy="mantenimientoHp">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Número de polos</label>
                                    <input type="number" step="2" min="2" class="form-control"
                                        wire:model.lazy="mantenimientoPolos">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Voltaje</label>
                                    <input type="number" step="0.01" min="0" class="form-control"
                                        wire:model.lazy="mantenimientoVoltaje">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Precio mantenimiento base
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="modalItemPrecioUnitario">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Costos adicionales
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="mantenimientoCostoAdicional">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Costo pruebas
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="mantenimientoCostoPruebas">
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-light border py-2">
                                <div class="d-flex justify-content-between">
                                    <span>Total mantenimiento:</span>
                                    <strong>{{ $this->simboloMoneda() }}{{ number_format($this->totalMantenimientoModal(), 2) }}</strong>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span>Item automático de pruebas:</span>
                                    <strong>{{ $this->simboloMoneda() }}{{ number_format((float) $mantenimientoCostoPruebas, 2) }}</strong>
                                </div>
                            </div>

                            <hr>
                        @endif
                        @if ($modalItemTipo === 'balanceo')
                            <div class="alert alert-info py-2">
                                Complete o ajuste los datos técnicos para calcular el precio del balanceo dinámico.
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Potencia HP</label>

                                    <input type="number" step="0.01" min="0" class="form-control"
                                        wire:model.lazy="balanceoHp">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Número de polos</label>

                                    <input type="number" step="2" min="2" class="form-control"
                                        wire:model.lazy="balanceoPolos">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Precio balanceo</label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>

                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="modalItemPrecioUnitario">
                                    </div>
                                </div>
                            </div>

                            <hr>
                        @endif
                        @if ($modalItemTipo === 'encamisado')
                            <div class="alert alert-info py-2">
                                Seleccione el rodamiento o ingrese el diámetro exterior para calcular el precio del
                                encamisado.
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Rodamiento
                                    </label>

                                    <select class="form-select" wire:model="encamisadoRodamientoCodigo">
                                        <option value="">Seleccione rodamiento</option>

                                        @foreach ($rodamientosCatalogo as $rodamiento)
                                            <option value="{{ $rodamiento['codigo'] }}">
                                                {{ $rodamiento['codigo'] }} - Ø
                                                {{ number_format((float) $rodamiento['diametro_exterior_mm'], 0) }} mm
                                            </option>
                                        @endforeach

                                        <option value="OTRO">Otro Rodamiento</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Diámetro exterior del rodamiento
                                    </label>

                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="encamisadoDiametroExterior">

                                        <span class="input-group-text">mm</span>
                                    </div>

                                    @error('encamisadoDiametroExterior')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="encamisadoProfundoSwitch"
                                            wire:model="encamisadoProfundo">

                                        <label class="form-check-label" for="encamisadoProfundoSwitch">
                                            Alojamiento profundo o sobredimensionado
                                        </label>
                                    </div>

                                    <div class="small text-muted">
                                        Multiplica el precio por 1.30
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="encamisadoRanuraSwitch"
                                            wire:model="encamisadoRanura">

                                        <label class="form-check-label" for="encamisadoRanuraSwitch">
                                            Ranura de O-ring o seguro
                                        </label>
                                    </div>

                                    <div class="small text-muted">
                                        Hasta 120mm: x1.20 / Mayor a 120mm: x1.15
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Precio base
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>

                                        <input type="number" step="0.01" class="form-control"
                                            value="{{ number_format((float) $encamisadoPrecioBase, 2, '.', '') }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Precio encamisado
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>

                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="modalItemPrecioUnitario">
                                    </div>
                                </div>
                            </div>

                            <hr>
                        @endif
                        @if ($modalItemTipo === 'rodamiento')
                            <div class="alert alert-info py-2">
                                Configure la designación del rodamiento. El precio exacto se reutilizará en futuras
                                cotizaciones.
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Rodamiento base</label>

                                    <select class="form-select" wire:model="rodamientoCodigo">
                                        <option value="">Seleccione rodamiento</option>

                                        @foreach ($rodamientosCatalogo as $rodamiento)
                                            <option value="{{ $rodamiento['codigo'] }}">
                                                {{ $rodamiento['codigo'] }} - Ø
                                                {{ number_format((float) $rodamiento['diametro_exterior_mm'], 0) }} mm
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Marca</label>

                                    <select class="form-select" wire:model="rodamientoMarca">
                                        <option value="SKF">SKF</option>
                                        <option value="FAG">FAG</option>
                                        <option value="NSK">NSK</option>
                                        <option value="NTN">NTN</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sellos</label>

                                    <select class="form-select" wire:model="rodamientoSellos">
                                        <option value="">Sin nada</option>
                                        <option value="ZZ">ZZ</option>
                                        <option value="2RS">2RS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Jaula</label>

                                    <select class="form-select" wire:model="rodamientoJaula">
                                        @foreach ($this->jaulasRodamientoDisponibles() as $jaula)
                                            <option value="{{ $jaula }}">
                                                {{ $jaula ?: 'Normal' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Juego radial</label>

                                    <select class="form-select" wire:model="rodamientoJuegoRadial">
                                        <option value="">Normal</option>
                                        <option value="C3">C3</option>
                                        <option value="C4">C4</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Aislamiento</label>

                                    <select class="form-select" wire:model="rodamientoAislamiento">
                                        <option value="">Sin aislamiento</option>
                                        <option value="VLO241">VLO241</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Designación generada</label>

                                <input type="text" class="form-control fw-bold" wire:model="rodamientoDesignacion"
                                    readonly>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Precio del rodamiento</label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>

                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="modalItemPrecioUnitario">
                                    </div>

                                    <div class="small text-muted mt-1">
                                        Este precio se guardará para esta designación exacta.
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Diámetro exterior</label>

                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control"
                                            wire:model="rodamientoDiametroExterior" readonly>

                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>

                            @if (count($rodamientoReferenciasPrecio) > 0)
                                <div class="accordion mb-3" id="accordionReferenciasRodamiento">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingReferenciasRodamiento">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseReferenciasRodamiento" aria-expanded="false"
                                                aria-controls="collapseReferenciasRodamiento">
                                                Referencias de precios similares
                                            </button>
                                        </h2>

                                        <div id="collapseReferenciasRodamiento" class="accordion-collapse collapse"
                                            aria-labelledby="headingReferenciasRodamiento"
                                            data-bs-parent="#accordionReferenciasRodamiento">
                                            <div class="accordion-body p-0">
                                                <table class="table table-sm table-striped mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Designación</th>
                                                            <th class="text-end">Precio</th>
                                                            <th class="text-center">Usos</th>
                                                            <th>Última actualización</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($rodamientoReferenciasPrecio as $referencia)
                                                            <tr>
                                                                <td>{{ $referencia['designacion'] }}</td>

                                                                <td class="text-end">
                                                                    {{ $referencia['moneda'] === 'USD' ? '$' : 'Q' }}{{ number_format($referencia['precio'], 2) }}
                                                                </td>

                                                                <td class="text-center">
                                                                    {{ $referencia['veces_usado'] }}
                                                                </td>

                                                                <td>
                                                                    {{ $referencia['fecha'] }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr>
                        @endif
                        @if ($modalItemTipo === 'pruebas')
                            <div class="alert alert-info py-2">
                                Configure el tipo de prueba, ubicación, tensión y cantidad de equipos.
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo de prueba</label>

                                    <select class="form-select" wire:model="pruebaTipo">
                                        <option value="estaticas">Pruebas Estáticas</option>
                                        <option value="dinamicas">Pruebas Dinámicas</option>
                                        <option value="vibraciones">Pruebas de Vibraciones</option>
                                        <option value="termografia">Termografía</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label d-block">Ubicación</label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="pruebasTaller"
                                            value="taller" wire:model="pruebaUbicacion">
                                        <label class="form-check-label" for="pruebasTaller">
                                            En taller
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="pruebasSitio"
                                            value="sitio" wire:model="pruebaUbicacion">
                                        <label class="form-check-label" for="pruebasSitio">
                                            En sitio
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Clasificación de tensión</label>

                                    <input type="text" class="form-control"
                                        value="{{ $pruebaTensionTipo === 'MT' ? 'Media tensión > 1000V' : 'Baja tensión <= 1000V' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Potencia HP</label>

                                    <input type="number" step="0.01" min="0" class="form-control"
                                        wire:model.lazy="pruebaHp">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Voltaje</label>

                                    <div class="input-group">
                                        <input type="number" step="0.01" min="1" class="form-control"
                                            wire:model.lazy="pruebaVoltaje">
                                        <span class="input-group-text">V</span>
                                    </div>
                                </div>

                                @if ($pruebaUbicacion === 'sitio')
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Cantidad de equipos</label>

                                        <input type="number" step="1" min="1" class="form-control"
                                            wire:model.lazy="pruebaCantidadEquipos">
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Precio unitario {{ $pruebaUbicacion === 'sitio' ? 'por equipo' : '' }}
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>

                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="modalItemPrecioUnitario">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Total pruebas
                                    </label>

                                    <div class="form-control fw-bold">
                                        {{ $this->simboloMoneda() }}{{ number_format($this->totalPruebasModal(), 2) }}
                                    </div>
                                </div>
                            </div>

                            @if (count($pruebaReferenciasPrecio) > 0)
                                <div class="accordion mb-3" id="accordionReferenciasPruebas">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingReferenciasPruebas">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseReferenciasPruebas"
                                                aria-expanded="false" aria-controls="collapseReferenciasPruebas">
                                                Referencias de precios similares
                                            </button>
                                        </h2>

                                        <div id="collapseReferenciasPruebas" class="accordion-collapse collapse"
                                            aria-labelledby="headingReferenciasPruebas"
                                            data-bs-parent="#accordionReferenciasPruebas">
                                            <div class="accordion-body p-0">
                                                <table class="table table-sm table-striped mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Cliente</th>
                                                            <th>Referencia</th>
                                                            <th class="text-center">Voltaje</th>
                                                            <th class="text-center">Equipos</th>
                                                            <th class="text-end">Unitario</th>
                                                            <th class="text-end">Total</th>
                                                            <th>Fecha</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($pruebaReferenciasPrecio as $referencia)
                                                            <tr>
                                                                <td>{{ $referencia['cliente'] }}</td>

                                                                <td>
                                                                    {{ $referencia['nombre'] }}
                                                                    @if ($referencia['hp'])
                                                                        <div class="small text-muted">
                                                                            {{ $referencia['hp'] }} HP
                                                                        </div>
                                                                    @endif
                                                                </td>

                                                                <td class="text-center">
                                                                    {{ $referencia['voltaje'] }}V
                                                                </td>

                                                                <td class="text-center">
                                                                    {{ $referencia['cantidad_equipos'] }}
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ $referencia['moneda'] === 'USD' ? '$' : 'Q' }}{{ number_format($referencia['precio_unitario'], 2) }}
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ $referencia['moneda'] === 'USD' ? '$' : 'Q' }}{{ number_format($referencia['precio_total'], 2) }}
                                                                </td>

                                                                <td>{{ $referencia['fecha'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr>
                        @endif
                        @if ($modalItemTipo === 'transporte')
                            <div class="alert alert-info py-2">
                                Ingrese el peso aproximado del equipo y el precio del traslado.
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Peso aproximado
                                    </label>

                                    <div class="input-group">
                                        <input type="number" step="0.001" min="0" class="form-control"
                                            wire:model.lazy="transporteTonelaje">

                                        <span class="input-group-text">Ton</span>
                                    </div>

                                    <div class="small text-muted">
                                        70 lb ≈ 0.032 Ton.
                                    </div>

                                    @error('transporteTonelaje')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Modalidad calculada
                                    </label>

                                    <input type="text" class="form-control"
                                        value="{{ $transporteVehiculo ?: 'Pendiente de peso' }}" readonly>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Precio transporte
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">{{ $this->simboloMoneda() }}</span>

                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.lazy="modalItemPrecioUnitario">
                                    </div>

                                    @error('modalItemPrecioUnitario')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="alert alert-light border py-2">
                                <div class="fw-semibold mb-1">
                                    Rangos de transporte
                                </div>

                                <div class="small">
                                    <strong>Moto:</strong> menos de 70 lb<br>
                                    <strong>Pickup o Camioncito:</strong> 70 lb a 2.5 Ton<br>
                                    <strong>Camión Grúa:</strong> 2.5 Ton a 7 Ton<br>
                                    <strong>Plataforma o Lowboy:</strong> mayor a 7 Ton
                                </div>
                            </div>

                            <hr>
                        @endif
                        @if ($modalItemTipo === 'descuento')
                            <div class="alert alert-info py-2">
                                Configure el porcentaje y el alcance del descuento especial.
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        % de descuento
                                    </label>

                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" max="100"
                                            class="form-control" wire:model.lazy="descuentoPorcentaje">

                                        <span class="input-group-text">%</span>
                                    </div>

                                    @error('descuentoPorcentaje')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label d-block">
                                        Aplicar descuento
                                    </label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="descuentoPrincipal"
                                            value="principal" wire:model="descuentoAlcance">

                                        <label class="form-check-label" for="descuentoPrincipal">
                                            Solo al item principal, rebobinado o mantenimiento
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="descuentoTodos"
                                            value="todos" wire:model="descuentoAlcance">

                                        <label class="form-check-label" for="descuentoTodos">
                                            A todos los items de la cotización
                                        </label>
                                    </div>

                                    @error('descuentoAlcance')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            @if (count($descuentoItemsPreview) > 0)
                                <div class="table-responsive scrollbar mb-3">
                                    <table class="table table-sm table-striped table-bordered mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Item</th>
                                                <th class="text-end">Precio original</th>
                                                <th class="text-end">Precio con descuento</th>
                                                <th class="text-end">Diferencia</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($descuentoItemsPreview as $preview)
                                                <tr>
                                                    <td>{{ $preview['nombre'] }}</td>

                                                    <td class="text-end">
                                                        {{ $this->simboloMoneda() }}{{ number_format($preview['precio_original'], 2) }}
                                                    </td>

                                                    <td class="text-end">
                                                        {{ $this->simboloMoneda() }}{{ number_format($preview['precio_con_descuento'], 2) }}
                                                    </td>

                                                    <td class="text-end text-danger">
                                                        -{{ $this->simboloMoneda() }}{{ number_format($preview['diferencia'], 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">
                                                    Total descuento
                                                </td>

                                                <td class="text-end fw-bold text-danger">
                                                    -{{ $this->simboloMoneda() }}{{ number_format($descuentoTotal, 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning py-2">
                                    No hay items válidos para aplicar descuento.
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">
                                    Descripción
                                </label>

                                <textarea class="form-control" rows="3" wire:model.defer="modalItemDescripcion"></textarea>
                            </div>

                            <hr>
                        @endif
                        @if (
                            !in_array($modalItemTipo, [
                                'rebobinado',
                                'mantenimiento',
                                'balanceo',
                                'encamisado',
                                'rodamiento',
                                'pruebas',
                                'transporte',
                                'descuento',
                            ]))
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cantidad</label>

                                    <input type="number" step="0.01" min="0" class="form-control"
                                        wire:model.defer="modalItemCantidad">

                                    @error('modalItemCantidad')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Precio Unitario</label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            {{ $this->simboloMoneda() }}
                                        </span>

                                        <input type="number" step="0.01" min="0" class="form-control"
                                            wire:model.defer="modalItemPrecioUnitario">
                                    </div>

                                    @error('modalItemPrecioUnitario')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                        Cerrar
                    </button>

                    <button class="btn btn-primary" type="button" wire:click="guardarItemDesdeModal"
                        wire:loading.attr="disabled" wire:target="guardarItemDesdeModal">
                        Agregar item
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="opcionesPdfCotizacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 650px">
            <div class="modal-content position-relative">

                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        type="button" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1">
                            Opciones para generar PDF
                        </h4>

                        <p class="mb-0 small text-muted">
                            Configure cómo desea generar la cotización antes de guardar y crear el PDF.
                        </p>
                    </div>

                    <div class="p-4 pb-0">
                        <div class="mb-3">
                            <label class="form-label">
                                Título de la cotización
                            </label>

                            <input type="text" class="form-control form-control-lg"
                                wire:model.defer="tituloCotizacion" placeholder="Oferta Presupuestaria">

                            @error('tituloCotizacion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div class="form-text">
                                Este título será guardado en la cotización y luego usado en el PDF.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Subtítulo de la cotización
                            </label>

                            <input type="text" class="form-control" wire:model.defer="subtituloCotizacion"
                                placeholder="Resumen del tipo de cotización">

                            @error('subtituloCotizacion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div class="form-text">
                                Puede usarse como resumen corto debajo del título principal.
                            </div>
                        </div>

                        <hr>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="pdfUsarPortadaSwitch"
                                wire:model.defer="pdfUsarPortada">

                            <label class="form-check-label" for="pdfUsarPortadaSwitch">
                                Agregar portada a la cotización
                            </label>
                        </div>

                        <div class="alert alert-light border small mb-0">
                            Más adelante aquí agregaremos:
                            tipos de portada, carta de presentación, merge de cotizaciones,
                            términos y texto final.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button class="btn btn-danger" type="button" x-data="{ generandoPdf: false }"
                        x-on:click="
        generandoPdf = true;

        window.cotizacionPdfWindow = window.open('', '_blank');

        if (window.cotizacionPdfWindow) {
            window.cotizacionPdfWindow.document.write(`
                <html>
                    <head>
                        <title>Generando PDF...</title>
                        <style>
                            body {
                                font-family: Arial, Helvetica, sans-serif;
                                padding: 40px;
                                color: #222;
                            }
                        </style>
                    </head>
                    <body>
                        <h3>Generando PDF...</h3>
                        <p>Por favor espere.</p>
                    </body>
                </html>
            `);

            window.cotizacionPdfWindow.document.close();
        }

        $wire.guardarCotizacion(true);
    "
                        x-bind:disabled="generandoPdf" x-on:cotizacion-pdf-finalizado.window="generandoPdf = false">

                        <span x-show="!generandoPdf">
                            <i class="far fa-file-pdf me-1"></i>
                            Guardar y generar PDF
                        </span>

                        <span x-show="generandoPdf">
                            <span class="spinner-border spinner-border-sm me-1" role="status"
                                aria-hidden="true"></span>
                            Generando PDF...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="noIncluyeCotizacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 750px">
            <div class="modal-content">

                <div class="modal-header bg-light">
                    <h5 class="modal-title">Agregar exclusiones</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    <h6>Opciones rápidas</h6>

                    <div class="row">
                        @foreach ($noIncluyeOpcionesRapidas as $index => $opcion)
                            <div class="col-md-6 mb-2">
                                <button type="button" class="btn btn-outline-secondary w-100 text-start"
                                    wire:click="agregarNoIncluyeRapido({{ $index }})">
                                    {{ $opcion }}
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <h6>Agregar otro</h6>

                    <div class="input-group">
                        <span class="input-group-text">No incluye</span>

                        <input type="text" class="form-control" wire:model.defer="noIncluyePersonalizado"
                            placeholder="Ingrese otro concepto no incluido">

                        <button type="button" class="btn btn-primary" wire:click="agregarNoIncluyePersonalizado">
                            Agregar
                        </button>
                    </div>

                    @error('noIncluyePersonalizado')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    @if (count($noIncluyeItems) > 0)
                        <hr>

                        <h6>Agregados</h6>

                        <ul class="list-group">
                            @foreach ($noIncluyeItems as $index => $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $item }}</span>

                                    <button type="button" class="btn btn-link text-danger p-0"
                                        wire:click="eliminarNoIncluye({{ $index }})">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="garantiaCotizacionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 700px">
            <div class="modal-content">

                <div class="modal-header bg-light">
                    <h5 class="modal-title">Configurar garantía</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Tipo de garantía</label>

                        <select class="form-select" wire:model="garantiaModo">
                            <option value="general">Garantía general</option>
                            <option value="separada">Garantía separada eléctrica / mecánica</option>
                        </select>
                    </div>

                    @if ($garantiaModo === 'general')
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="garantiaGeneralActivaSwitch"
                                wire:model="garantiaGeneralActiva">

                            <label class="form-check-label" for="garantiaGeneralActivaSwitch">
                                Aplicar garantía general
                            </label>
                        </div>

                        @if ($garantiaGeneralActiva)
                            <div class="mb-3">
                                <label class="form-label">Tiempo de garantía</label>

                                <select class="form-select" wire:model="garantiaGeneralTiempo">
                                    <option value="30_dias">30 días</option>
                                    <option value="3_meses">3 meses</option>
                                    <option value="6_meses">6 meses</option>
                                    <option value="1_anio">1 año</option>
                                    <option value="2_anios">2 años</option>
                                </select>
                            </div>
                        @endif
                    @endif

                    @if ($garantiaModo === 'separada')
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Garantía componentes eléctricos
                                </label>

                                <select class="form-select" wire:model="garantiaElectricaTiempo">
                                    <option value="30_dias">30 días</option>
                                    <option value="3_meses">3 meses</option>
                                    <option value="6_meses">6 meses</option>
                                    <option value="1_anio">1 año</option>
                                    <option value="2_anios">2 años</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Garantía componentes mecánicos
                                </label>

                                <select class="form-select" wire:model="garantiaMecanicaTiempo">
                                    <option value="30_dias">30 días</option>
                                    <option value="3_meses">3 meses</option>
                                    <option value="6_meses">6 meses</option>
                                    <option value="1_anio">1 año</option>
                                    <option value="2_anios">2 años</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    <hr>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="incluirTerminosGarantiasSwitch"
                            wire:model="incluirTerminosGarantias">

                        <label class="form-check-label" for="incluirTerminosGarantiasSwitch">
                            Agregar página final de términos de cotización y garantías
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            //typeof Sortable !== 'undefined' && console.log('Sortable loaded');
            const contactosSelect = document.getElementById('contactosMultiple');

            if (!contactosSelect) return;

            const contactosChoices = new Choices(contactosSelect, {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                placeholder: true,
                placeholderValue: 'Seleccione contactos',
                searchPlaceholderValue: 'Buscar contacto...',
                noChoicesText: 'No hay contactos disponibles',
                noResultsText: 'No se encontraron contactos',
                itemSelectText: 'Presione para seleccionar',
            });

            window.addEventListener('contactos-cargados', function(event) {
                const contactos = event.detail.contactos || [];
                const selected = (event.detail.selected || []).map(String);

                contactosChoices.clearStore();

                contactosChoices.setChoices(
                    contactos.map(contacto => ({
                        value: contacto.value,
                        label: contacto.label,
                        selected: selected.includes(String(contacto.value)),
                        disabled: false,
                    })),
                    'value',
                    'label',
                    true
                );
            });

            contactosSelect.addEventListener('change', function() {
                const selectedValues = contactosChoices.getValue(true);

                @this.set('contactosSeleccionados', selectedValues);
            });

            window.addEventListener('abrir-modal-contacto-cotizacion', function() {
                const modalEl = document.getElementById('editarContactoCotizacionModal');

                if (!modalEl) return;

                const modal = bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);

                modal.show();
            });

            window.addEventListener('cerrar-modal-contacto-cotizacion', function() {
                const modalEl = document.getElementById('editarContactoCotizacionModal');

                if (!modalEl) return;

                const modal = bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);

                modal.hide();

                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
            });

            window.addEventListener('contacto-cotizacion-actualizado', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Contacto actualizado!',
                    text: 'La información del contacto fue guardada correctamente.',
                    timer: 1800,
                    showConfirmButton: false
                });
            });
            window.addEventListener('cliente-cambiado-por-os', function(event) {
                Swal.fire({
                    icon: 'info',
                    title: 'Cliente actualizado',
                    text: 'La OS ' + event.detail.os + ' pertenece a ' + event.detail.cliente +
                        '. Seleccione nuevamente los contactos.',
                    timer: 2800,
                    showConfirmButton: false
                });
            });
        });
        document.addEventListener('livewire:load', function() {
            function iniciarTinyPresentacion() {
                const editorId = 'textoPresentacionEditor';

                if (!document.getElementById(editorId)) {
                    return;
                }

                if (tinymce.get(editorId)) {
                    tinymce.get(editorId).remove();
                }

                tinymce.init({
                    selector: '#' + editorId,
                    height: 260,
                    menubar: false,
                    branding: false,
                    plugins: 'lists link table code',
                    toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright | code',
                    content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',

                    setup: function(editor) {
                        editor.on('init', function() {
                            editor.setContent(@json($textoPresentacion ?? ''));
                        });

                        editor.on('change keyup', function() {
                            @this.set('textoPresentacion', editor.getContent());
                        });
                    }
                });
            }

            iniciarTinyPresentacion();


        });
    </script>
    <script>
        function cotizacionPresentacionLoader() {
            return {
                open: true,
                loadingPresentacion: false,
                progressPresentacion: 0,
                progressTimer: null,
                safetyTimer: null,

                iniciarCargaPresentacion() {
                    this.loadingPresentacion = true;
                    this.progressPresentacion = 10;

                    clearInterval(this.progressTimer);
                    clearTimeout(this.safetyTimer);

                    this.progressTimer = setInterval(() => {
                        if (this.progressPresentacion < 85) {
                            this.progressPresentacion += 5;
                        }

                        if (this.progressPresentacion > 85) {
                            this.progressPresentacion = 85;
                        }
                    }, 120);

                    this.safetyTimer = setTimeout(() => {
                        this.finalizarCargaPresentacion();
                    }, 8000);
                },

                finalizarCargaPresentacion() {
                    clearInterval(this.progressTimer);
                    clearTimeout(this.safetyTimer);

                    this.progressPresentacion = 100;

                    setTimeout(() => {
                        this.loadingPresentacion = false;
                        this.progressPresentacion = 0;
                    }, 350);
                }
            }
        }

        window.addEventListener('actualizar-texto-presentacion', function(event) {
            const contenido = event.detail.contenido || '';

            if (typeof tinymce !== 'undefined') {
                const editor = tinymce.get('textoPresentacionEditor');

                if (editor) {
                    editor.setContent(contenido);

                    /*
                     * Le damos un pequeño margen a TinyMCE para terminar de pintar.
                     */
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('texto-presentacion-cargado'));
                    }, 250);

                    return;
                }
            }

            const textarea = document.getElementById('textoPresentacionEditor');

            if (textarea) {
                textarea.value = contenido;
            }

            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('texto-presentacion-cargado'));
            }, 250);
        });
    </script>
    <script>
        window.addEventListener('abrir-modal-item-cotizacion', function() {
            const modalEl = document.getElementById('itemCotizacionModal');

            if (!modalEl) return;

            const modal = bootstrap.Modal.getInstance(modalEl) ||
                new bootstrap.Modal(modalEl);

            modal.show();
        });

        window.addEventListener('cerrar-modal-item-cotizacion', function() {
            const modalEl = document.getElementById('itemCotizacionModal');

            if (!modalEl) return;

            const modal = bootstrap.Modal.getInstance(modalEl) ||
                new bootstrap.Modal(modalEl);

            modal.hide();

            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        });

        window.addEventListener('item-cotizacion-agregado', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Item agregado!',
                text: 'El item fue agregado a la cotización.',
                timer: 1500,
                showConfirmButton: false
            });
        });
    </script>

    <script>
        function scrollItemsCotizacionTop() {
            const card = document.getElementById('cardItemsCotizacion');

            if (!card) return;

            const y = card.getBoundingClientRect().top + window.pageYOffset - 80;

            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
        }

        function activarEspacioBuscadorItems() {
            const card = document.getElementById('cardItemsCotizacion');
            const tablaWrapper = document.getElementById('tablaItemsCotizacionWrapper');

            if (card) {
                card.classList.add('items-search-open');
            }

            if (tablaWrapper) {
                tablaWrapper.classList.add('search-active');
            }
        }

        function desactivarEspacioBuscadorItems() {
            const card = document.getElementById('cardItemsCotizacion');
            const tablaWrapper = document.getElementById('tablaItemsCotizacionWrapper');

            if (card) {
                card.classList.remove('items-search-open');
            }

            if (tablaWrapper) {
                tablaWrapper.classList.remove('search-active');
            }
        }

        function enfocarBuscadorItems() {
            setTimeout(function() {
                const input = document.getElementById('buscadorItemsCotizacionInput');

                if (input) {
                    input.focus();
                }
            }, 350);
        }

        window.addEventListener('pre-abrir-buscador-items-cotizacion', function() {
            activarEspacioBuscadorItems();

            setTimeout(function() {
                scrollItemsCotizacionTop();
            }, 50);
        });

        window.addEventListener('abrir-buscador-items-cotizacion', function() {
            activarEspacioBuscadorItems();

            setTimeout(function() {
                scrollItemsCotizacionTop();
                enfocarBuscadorItems();
            }, 150);
        });

        window.addEventListener('cerrar-buscador-items-cotizacion', function() {
            desactivarEspacioBuscadorItems();
        });
    </script>
    <script src="{{ asset('vendors/sortable/Sortable.min.js') }}"></script>

    <script>
        function initSortableItemsCotizacion() {
            const tbody = document.getElementById('itemsCotizacionSortable');

            if (!tbody) {
                console.log('Sortable: no existe #itemsCotizacionSortable');
                return;
            }

            if (typeof Sortable === 'undefined') {
                console.log('Sortable: librería no cargada');
                return;
            }

            const rows = tbody.querySelectorAll('tr[data-uid]');

            if (rows.length < 2) {

            }

            if (tbody._sortableInstance) {
                tbody._sortableInstance.destroy();
                tbody._sortableInstance = null;
            }

            tbody._sortableInstance = new Sortable(tbody, {
                draggable: 'tr[data-uid]',
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                forceFallback: true,
                fallbackOnBody: true,

                onStart: function() {

                },

                onEnd: function() {


                    const orden = Array.from(
                        tbody.querySelectorAll('tr[data-uid]')
                    ).map(row => row.dataset.uid);

                    console.log('Nuevo orden:', orden);

                    const livewireRoot = tbody.closest('[wire\\:id]');

                    if (!livewireRoot) {
                        // console.log('Sortable: no encontré componente Livewire');
                        return;
                    }

                    const componentId = livewireRoot.getAttribute('wire:id');

                    Livewire.find(componentId).call('ordenarItemsCotizacion', orden);
                }
            });

            // console.log('Sortable inicializado:', rows.length, 'items');
        }

        document.addEventListener('livewire:load', function() {
            setTimeout(initSortableItemsCotizacion, 300);

            Livewire.hook('message.processed', function() {
                setTimeout(initSortableItemsCotizacion, 100);
            });
        });
    </script>
    <script>
        window.addEventListener('abrir-modal-opciones-pdf-cotizacion', function() {
            const modalElement = document.getElementById('opcionesPdfCotizacionModal');

            if (!modalElement) {
                return;
            }

            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    </script>
    <script>
        window.addEventListener('cotizacion-pdf-listo', function(event) {
            const url = event.detail.url;

            const modalElement = document.getElementById('opcionesPdfCotizacionModal');

            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);

                if (modal) {
                    modal.hide();
                }
            }

            if (window.cotizacionPdfWindow && !window.cotizacionPdfWindow.closed) {
                window.cotizacionPdfWindow.location.href = url;
            } else {
                window.open(url, '_blank');
            }

            window.dispatchEvent(new CustomEvent('cotizacion-pdf-finalizado'));
        });
    </script>
    <script>
        window.addEventListener('abrir-modal-no-incluye-cotizacion', function() {
            const modalElement = document.getElementById('noIncluyeCotizacionModal');

            if (!modalElement) {
                return;
            }

            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });

        window.addEventListener('abrir-modal-garantia-cotizacion', function() {
            const modalElement = document.getElementById('garantiaCotizacionModal');

            if (!modalElement) {
                return;
            }

            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });

        document.addEventListener('livewire:load', function() {
            if (typeof tinymce !== 'undefined' && !tinymce.get('notasAdicionalesCotizacionEditor')) {
                tinymce.init({
                    selector: '#notasAdicionalesCotizacionEditor',
                    height: 220,
                    menubar: false,
                    plugins: 'lists link',
                    toolbar: 'undo redo | bold italic underline | bullist numlist | link',
                    setup: function(editor) {
                        editor.on('change keyup', function() {
                            @this.set('notasAdicionales', editor.getContent());
                        });
                    }
                });
            }
        });

        window.addEventListener('actualizar-notas-adicionales-cotizacion', function(event) {
            if (typeof tinymce === 'undefined') {
                return;
            }

            const editor = tinymce.get('notasAdicionalesCotizacionEditor');

            if (editor) {
                editor.setContent(event.detail.contenido || '');
            }
        });
    </script>
</div>
