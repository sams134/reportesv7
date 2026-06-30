<div>
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-0">Listado de precios</h3>
                <div class="text-muted">
                    Administración de precios base usados en cotizaciones.
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3">
            @foreach([
                'rebobinados' => 'Rebobinados',
                'mantenimientos' => 'Mantenimientos',
                'balanceos' => 'Balanceos',
                'encamisados' => 'Encamisados',
                'rodamientos' => 'Rodamientos',
                'pruebas' => 'Pruebas',
            ] as $key => $label)
                <li class="nav-item">
                    <button type="button"
                        class="nav-link {{ $tabActiva === $key ? 'active' : '' }}"
                        wire:click="$set('tabActiva', '{{ $key }}')">
                        {{ $label }}
                    </button>
                </li>
            @endforeach
        </ul>

        @if($tabActiva === 'rebobinados')
            @include('livewire.cotizaciones.listado-precios-tabs.rebobinados')
        @elseif($tabActiva === 'mantenimientos')
            @include('livewire.cotizaciones.listado-precios-tabs.mantenimientos')
        @elseif($tabActiva === 'balanceos')
            @include('livewire.cotizaciones.listado-precios-tabs.balanceos')
        @elseif($tabActiva === 'encamisados')
            @include('livewire.cotizaciones.listado-precios-tabs.encamisados')
        @elseif($tabActiva === 'rodamientos')
            @include('livewire.cotizaciones.listado-precios-tabs.rodamientos')
        @elseif($tabActiva === 'pruebas')
            @include('livewire.cotizaciones.listado-precios-tabs.pruebas')
        @endif

    </div>
</div>