<div class="position-relative" style="width: 100%;">
    <form class="position-relative" wire:submit.prevent="seleccionarPrimeraCoincidencia">
        <input id="searchOsCotizacionInput" class="form-control" type="search" placeholder="Buscar OS"
            wire:model.debounce.300ms="search" wire:focus="abrirDropdown"
            wire:keydown.enter.prevent="seleccionarPrimeraCoincidencia">
    </form>

    <div id="searchOsCotizacionDropdown"
        class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100 {{ $isOpen ? 'show' : '' }}"
        style="z-index: 1050;">
        <div class="scrollbar list py-3" style="max-height: 28rem;">

            {{-- PRIMER ITEM FIJO --}}
            <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                Oferta presupuestaria
            </h6>

            <a href="#" class="dropdown-item px-card py-2 fs-0"
                wire:mousedown.prevent="seleccionarOfertaPresupuestaria">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-m status-offline">
                        <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}" alt="No hay equipo">
                    </div>

                    <div class="ms-2">
                        <div class="fw-semibold">
                            Equipo no ha ingresado a taller
                        </div>
                        <div class="small text-muted">
                            Oferta presupuestaria
                        </div>
                    </div>
                </div>
            </a>

            {{-- SUGERENCIAS --}}
            @if (!$search && $cliente_id && count($sugerencias) > 0)
                <hr class="bg-200 dark__bg-900">

                <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                    Últimas órdenes activas del cliente
                </h6>

                @foreach ($sugerencias as $motor)
                    <a href="#" class="dropdown-item px-card py-1 fs-0"
                        wire:mousedown.prevent="seleccionarMotor({{ $motor['id_motor'] }})">
                        <div class="d-flex align-items-center justify-between">
                            @if (isset($motor['fotos']) &&
                                    count($motor['fotos']) > 0 &&
                                    isset($motor['fotos'][0]['thumb']) &&
                                    Storage::exists('public' . $motor['fotos'][0]['thumb']))
                                <div class="avatar avatar-m status-offline">
                                    <img class="rounded-circle"
                                        src="{{ asset('storage' . $motor['fotos'][0]['thumb']) }}" alt="">
                                </div>
                            @else
                                <div class="avatar avatar-m status-offline">
                                    <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
                                        alt="No hay foto">
                                </div>
                            @endif

                            <span class="mx-1 small">
                                {{ $motor['fullos'] ?? $motor['year'] . '-' . $motor['os'] }}:
                            </span>

                            <span class="small">
                                {{ Str::limit($motor['cliente']['cliente'] ?? '', 30, '...') }}
                            </span>

                            <x-status-badge class="ms-auto" status_id="{{ $motor['status_id'] }}" />
                        </div>
                    </a>
                @endforeach
            @endif

            {{-- RESULTADOS DE BÚSQUEDA --}}
            @if ($search)
                <hr class="bg-200 dark__bg-900">

                <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                    Equipos encontrados
                </h6>

                @if (count($motores) > 0)
                    @foreach ($motores as $motor)
                        <a href="#" class="dropdown-item px-card py-1 fs-0"
                            wire:mousedown.prevent="seleccionarMotor({{ $motor['id_motor'] }})">
                            <div class="d-flex align-items-center justify-between">
                                @if (isset($motor['fotos']) &&
                                        count($motor['fotos']) > 0 &&
                                        isset($motor['fotos'][0]['thumb']) &&
                                        Storage::exists('public' . $motor['fotos'][0]['thumb']))
                                    <div class="avatar avatar-m status-offline">
                                        <img class="rounded-circle"
                                            src="{{ asset('storage' . $motor['fotos'][0]['thumb']) }}" alt="">
                                    </div>
                                @else
                                    <div class="avatar avatar-m status-offline">
                                        <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
                                            alt="No hay foto">
                                    </div>
                                @endif

                                <span class="mx-1">
                                    {{ $motor['fullos'] ?? $motor['year'] . '-' . $motor['os'] }}:
                                </span>

                                <span>
                                    {{ Str::limit($motor['cliente']['cliente'] ?? '', 30, '...') }}
                                </span>

                                <x-status-badge class="ms-auto" status_id="{{ $motor['status_id'] }}" />
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="px-card py-2 small text-muted">
                        No se encontraron equipos. Puede usar la opción de oferta presupuestaria.
                    </div>
                @endif
            @endif

        </div>
    </div>
    <script>
        window.addEventListener('cerrar-dropdown-os-cotizacion', function() {
            const dropdown = document.getElementById('searchOsCotizacionDropdown');
            const input = document.getElementById('searchOsCotizacionInput');

            if (dropdown) {
                dropdown.classList.remove('show');
            }

            if (input) {
                input.blur();
            }
        });
    </script>
</div>
