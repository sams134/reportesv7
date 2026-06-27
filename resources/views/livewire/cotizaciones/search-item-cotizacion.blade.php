<div id="buscadorItemsCotizacionWrapper" class="w-100" style="{{ $modoBusqueda ? 'min-height: 470px;' : '' }}" x-data
    @click.outside="$wire.cerrarBuscador()">
    @if (!$modoBusqueda)
        <button type="button" class="btn btn-link px-0 text-primary fw-semibold"
            onclick="window.dispatchEvent(new CustomEvent('pre-abrir-buscador-items-cotizacion'))"
            wire:click="abrirBuscador">
            <i class="fas fa-plus-circle me-1"></i>
            Agregar otro Item
        </button>
    @else
        <input id="buscadorItemsCotizacionInput" type="search" class="form-control"
            placeholder="Buscar item o crear uno nuevo" wire:model.debounce.300ms="search" autofocus>

        <div id="dropdownItemsCotizacion"
            class="border font-base mt-2 py-0 overflow-hidden w-100 shadow-sm bg-white rounded {{ $isOpen ? 'd-block' : 'd-none' }}"
            style="z-index: 3000;">
            <div class="scrollbar list py-2" style="max-height: 390px;">

                {{-- CREAR NUEVO ITEM SIEMPRE VISIBLE --}}
                @if ($crearItem)
                    <a href="#" class="dropdown-item px-card py-2 fs-0"
                        wire:mousedown.prevent="seleccionarItem({{ $crearItem->id }})">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-plus-circle text-primary me-2"></i>

                            <div>
                                <div class="fw-semibold">
                                    {{ $crearItem->nombre }}
                                </div>
                                <div class="small text-muted">
                                    Crear un item personalizado para esta cotización
                                </div>
                            </div>
                        </div>
                    </a>
                @endif

                {{-- ITEMS RÁPIDOS --}}
                @if (!$search && count($itemsRapidos) > 0)
                    <hr class="bg-200 dark__bg-900 my-2">

                    <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                        Items comunes
                    </h6>

                    @foreach ($itemsRapidos as $item)
                        <a href="#" class="dropdown-item px-card py-2 fs-0"
                            wire:mousedown.prevent="seleccionarItem({{ $item->id }})">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $item->nombre }}
                                    </div>

                                    <div class="small text-muted">
                                        {{ \Illuminate\Support\Str::limit($item->descripcion, 80) }}
                                    </div>
                                </div>

                                @if ($item->precio > 0)
                                    <div class="ms-2 text-nowrap">
                                        Q{{ number_format($item->precio, 2) }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                @endif

                {{-- RESULTADOS DE BÚSQUEDA --}}
                @if ($search)
                    <hr class="bg-200 dark__bg-900 my-2">

                    <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                        Items encontrados
                    </h6>

                    @forelse ($resultados as $item)
                        <a href="#" class="dropdown-item px-card py-2 fs-0"
                            wire:mousedown.prevent="seleccionarItem({{ $item->id }})">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $item->nombre }}
                                    </div>

                                    <div class="small text-muted">
                                        {{ \Illuminate\Support\Str::limit($item->descripcion, 100) }}
                                    </div>
                                </div>

                                <div class="ms-2 text-nowrap">
                                    Q{{ number_format($item->precio, 2) }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-card py-2 small text-muted">
                            No se encontraron items con ese nombre.
                        </div>
                    @endforelse
                @endif

            </div>
        </div>
    @endif
    </div>
