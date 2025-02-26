<div class="search-box w-100" data-list='{"valueNames":["title"]}'>
    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
        <input id="searchInput" class="form-control search-input fuzzy-search" type="search" placeholder="Buscar" aria-label="Search"
        wire:model="search"
        onkeydown="if(event.key==='Enter'){ event.preventDefault(); window.location.href='{{ url('motores/index/search') }}/' + this.value; }" 
        wire:blur="resetSearch"/>
        <span class="fas fa-search search-box-icon"></span>

    </form>
    <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
        data-bs-dismiss="search">
        <div class="btn-close-falcon" aria-label="Close"></div>
    </div>
    <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100 {{ $search ? 'show' : '' }}">
        <div class="scrollbar list py-3" style="max-height: 28rem;">
            <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                Recientemente Buscados</h6>
            @if (count(Auth::user()->looks) > 0)
                @foreach (Auth::user()->looks()->orderBy('created_at', 'asc')->take(3)->get() as $look)
                
                    <a class="dropdown-item px-card py-1 fs-0" href="{{ route('motores.look', $look) }}" style="color:#888;font-size:10px;">
                        <div class="d-flex align-items-center justify-between">
                            @if (
                                $look->fotos &&
                                    $look->fotos->count() > 0 &&
                                    Storage::exists('public' . $look->fotos->first()->thumb))
                                <div class="avatar avatar-m status-offline">
                                    <img class="rounded-circle"
                                        src="{{ asset('storage' . $look->fotos->first()->thumb) }}"
                                        alt="" />
                                </div>
                            @else
                                <div class="avatar avatar-m status-offline">
                                    <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
                                        alt="No hay foto" />
                                </div>
                            @endif


                            <span class="mx-1 small"> {{ $look->fullos }}:</span>
                            <span class="small">{{ Str::limit($look->cliente->cliente, 30, '...') }}</span>
                            <x-status-badge class="ms-auto" status_id="{{ $look->status_id }}"> </x-status-badge>


                        </div>
                    </a>
                @endforeach
                @endif

                <hr class="bg-200 dark__bg-900" />
                <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                    Equipos Encontrados</h6>
                @if ($search && count($motores) > 0)
                    @foreach ($motores->take(5) as $motor)
                        <a class="dropdown-item px-card py-1 fs-0" href="{{ route('motores.look', $motor) }}">
                            <div class="d-flex align-items-center justify-between">
                                @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                                    <div class="avatar avatar-m status-offline">
                                        <img class="rounded-circle"
                                            src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                            alt="" />
                                    </div>
                                @else
                                    <div class="avatar avatar-m status-offline">
                                        <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
                                            alt="No hay foto" />
                                    </div>
                                @endif


                                <span class="mx-1"> {{ $motor->fullos }}:</span>
                                <span>{{ Str::limit($motor->cliente->cliente, 30, '...') }}</span>
                                <x-status-badge class="ms-auto" status_id="{{ $motor->status_id }}"> </x-status-badge>

                            </div>
                        </a>
                    @endforeach
                    @if (count($motores) > 0)
                        <a class="dropdown-item px-card py-1 fs-0" href="{{ route('motores.index.search',$search) }}">
                            <div class="d-flex align-items-center justify-between badge badge-soft-info">
                                @if (count($motores) > 30)
                                <span class="mx-1">Hay m&aacute;s de 30 coincidencias, Ver Todas</span>
                                @else
                                <span class="mx-1">Hay {{count($motores)}} coincidencias, Ver Todas</span>
                                @endif
                               
                            </div>
                        </a>
                        
                    @endif
                @endif


                <hr class="bg-200 dark__bg-900" />
                <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                    Metalizados</h6>
                    @if ($search && count($metalizados) > 0)
                    @foreach ($metalizados->take(5) as $motor)
                        <a class="dropdown-item px-card py-1 fs-0" href="{{ route('motores.look', $motor) }}">
                            <div class="d-flex align-items-center justify-between">
                                @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                                    <div class="avatar avatar-m status-offline">
                                        <img class="rounded-circle"
                                            src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                            alt="" />
                                    </div>
                                @else
                                    <div class="avatar avatar-m status-offline">
                                        <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
                                            alt="No hay foto" />
                                    </div>
                                @endif


                                <span class="mx-1"> {{ $motor->fullos }}:</span>
                                <span>{{ Str::limit($motor->cliente->cliente, 30, '...') }}</span>
                                <x-status-badge class="ms-auto" status_id="{{ $motor->status_id }}"> </x-status-badge>

                            </div>
                        </a>
                    @endforeach
                @endif

                <hr class="bg-200 dark__bg-900" />
                

        </div>
        <div class="text-center mt-n3">
            <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
        </div>
    </div>
</div>
