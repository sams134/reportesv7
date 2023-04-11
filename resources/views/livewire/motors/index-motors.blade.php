<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <x-pretty-card>
        <h2>Listado General de Motores</h2>
        Revisa todos los motores en el sistema
    </x-pretty-card>
    <x-pretty-card>
        <a class="btn btn-outline-primary me-1 mb-1" type="button" href="{{ route('motores.create') }}">
            <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Nuevo Equipo
        </a>
    </x-pretty-card>
    <div class="card" id="runningProjectTable" data-list='{"valueNames":["projects","worked","time","date"]}'>
        <div class="card-header">
            <h6 class="mb-0">Ordenes de Servicio</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                <table class="table table-hover table-striped overflow-hidden fs--1">
                    <thead class="bg-300 text-dark">
                        <tr class="text-800">
                            <th style="width:30px"><input type="checkbox" name="" id=""> </th>
                            <th style="width:1rem"></th>
                            <th class="sort " style="width:15%;cursor: pointer;">Orden de Servicio</th>
                            <th class="sort ">Cliente</th>
                            <th class="sort ">Potencia</th>
                            <th class="sort d-none d-xl-table-cell">Rpm</th>
                            <th class="sort d-none d-xxl-table-cell">Marca</th>
                            <th class="sort ">Status</th>
                            <th class="sort d-none d-lg-table-cell">Ingreso</th>
                            <th>Tecnicos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($motores as $motor)
                            <tr>
                                <td style="width:30px"><input type="checkbox" name="" id=""
                                        class="align-bottom"></td>
                                <td>
                                    <div class="col-auto">
                                        @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists($motor->fotos->first()->thumb))
                                            <div class="avatar avatar-2xl status-offline">
                                                <img class="rounded-circle"
                                                    src="{{ Storage::url($motor->fotos->first()->thumb) }}"
                                                    alt="" />
                                            </div>
                                        @else
                                            <div class="avatar avatar-2xl status-offline">
                                                <img class="rounded-circle"
                                                    src="{{ asset('img/default-avatar.png') }}" alt="No hay foto" />
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center position-relative">
                                        {{--   --}}
                                        <div class="flex-1 ms-1">
                                            <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"
                                                    href="{{ route('motores.downloadPdf', $motor) }}">{{ $motor->fullOs }}</a>
                                            </h6>
                                            <p class="text-500 fs--2 mb-0">{{ $motor->id_tipoequipo }}</p>
                                        </div>
                                    </div>

                                </td>
                                <td class="align-middle">{{ $motor->cliente->cliente }}</td>
                                <td class="align-middle ">{{ $motor->potencia }}</td>
                                <td class="align-middle text-uppercase d-none d-xl-table-cell">{{ $motor->rpm }}</td>
                                <td class="align-middle text-uppercase d-none d-xxl-table-cell">{{ $motor->marca }}</td>
                                <td class="align-middle ">
                                    <x-status-badge status_id="{{ $motor->status_id }}" />
                                </td>
                                <td class="align-middle d-none d-lg-table-cell">
                                    <div style="d-block">
                                        {{ Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}
                                    </div>

                                    <small>
                                        {{ Carbon\Carbon::parse($motor->fecha_ingreso)->diffForHumans() }}
                                    </small>

                                </td>
                                <td>
                                    @foreach ($motor->tecnicos as $tecnico)
                                        <div class="avatar avatar-xl">

                                            <img src="{{ asset($tecnico->foto) }}" alt=""
                                                class="rounded-circle">

                                        </div>
                                    @endforeach


                                </td>
                                <td class="text-end">
                                    <div>
                                        <button class="btn p-0" type="button" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Editar"><span
                                                class="text-500 fas fa-edit"></span></button>
                                        <button class="btn p-0 ms-2" type="button" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Eliminar"><span
                                                class="text-500 fas fa-trash-alt"></span></button>
                                    </div>
                                </td>


                            </tr>
                        @endforeach


                    </tbody>
                </table>
                {{ $motores->links() }}
            </div>
        </div>
        <div class="card-footer bg-light py-0 text-center"><a class="btn btn-sm btn-link py-2" href="#!">Show All
                Projects<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
    </div>
</div>
