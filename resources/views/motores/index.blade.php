<x-app-layout>
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
            <div class="scrollbar">
                <table
                    class="table mb-0 table-borderless fs--2 border-200 overflow-hidden table-running-project table-hover">
                    <thead class="bg-light">
                        <tr class="text-800">
                            <th style="width:30px"><input type="checkbox" name="" id=""> </th>
                            <th class="sort" style="width:15%">Orden de Servicio</th>
                            <th class="sort" style="width:25%">Cliente</th>
                            <th class="sort ">Potencia</th>
                            <th class="sort ">Estado</th>
                            <th class="sort ">Progreso</th>
                            <th>Tecnicos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($motores as $motor)
                            <tr>
                                <td style="width:30px"><input type="checkbox" name="" id=""></td>
                                <td>
                                    <div class="d-flex align-items-center position-relative">
                                        {{--   --}}
                                        <div class="flex-1 ms-1">
                                            <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"
                                                    href="">{{ $motor->fullOs }}</a></h6>
                                            <p class="text-500 fs--2 mb-0">{{ $motor->cliente->cliente }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle ">{{ $motor->cliente->cliente }}</td>
                                <td class="align-middle ">{{ $motor->potencia }}</td>
                                <td class="align-middle ">{{ $motor->status_id }}</td>
                                <td class="align-middle ">
                                    <div class="progress rounded-3 worked" style="height: 6px;">
                                        <div class="progress-bar bg-progress-gradient rounded-pill" role="progressbar"
                                            style="width: 50%" aria-valuenow="43.72" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
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
</x-app-layout>
