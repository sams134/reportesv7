<div>
    {{-- Success is as dangerous as failure. --}}
    <x-pretty-card>
        <h2>Listado General de metalizados en frio</h2>
    </x-pretty-card>
    <x-pretty-card>
        <a class="btn btn-outline-primary me-1 mb-1" type="button" href="{{ route('metalizados.create') }}">
            <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Nuevo Metalizado
        </a>
    </x-pretty-card>

    <x-pretty-card title="Listado de Metalizados" class="my-2">
        <div class="table-responsive scrollbar">
            <table class="table table-striped overflow-hidden">
                <thead>
                    <tr class="btn-reveal-trigger">
                        <th style="width:30px"><input type="checkbox" name="" id=""> </th>
                        <th style="width:1rem"></th>
                        <th scope="col">OS</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Potencia</th>
                        <th scope="col">OS Motor</th>
                        <th class="text-end" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($motores as $motor)
                        <tr class="btn-reveal-trigger">
                            <td style="width:30px"><input type="checkbox" name="" id=""
                                    class="align-bottom"></td>
                            <td>
                                <div class="col-auto">
                                    @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                                        <div class="avatar avatar-xl ">
                                            <img class="rounded-circle"
                                                src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                                alt="" />
                                        </div>
                                    @else
                                        <div class="avatar avatar-2xl ">
                                            <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
                                                alt="No hay foto" />
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $motor->fullos }}</td>
                            <td>{{ $motor->cliente->cliente }}</td>
                            <td>{{ $motor->potencia }}</td>
                            <td>{{ $motor->fullos }}</td>
                            <td class="text-end">
                                <div class="dropdown font-sans-serif position-static">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                        aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0">
                                        <div class="bg-white py-2"><a class="dropdown-item" href="#!">Edit</a><a
                                                class="dropdown-item text-danger" href="#!">Delete</a></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-pretty-card>


</div>
