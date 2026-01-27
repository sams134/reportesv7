<div>
    <x-pretty-card>
        <h2>Listado General de {{$title}}
        </h2>
        
    </x-pretty-card>
    <div class="card-body p-0">
        <span wire:loading> Loading</span>
        <div class="px-2"> </div>
        <div class="table-responsive scrollbar">
            <table class="table table-hover table-striped overflow-hidden fs--1" style="font-size: 0.5rem"
                wire:loading.remove>
                <thead class="bg-300 text-dark">
                    <tr class="text-800">
                        <th style="width:30px"><input type="checkbox" name="" id=""> </th>
                        <th style="width:1rem"></th>
                        <th>Job</th>
                        <th>Cliente</th>
                        <th>OS</th>
                        <th>Potencia</th>
                        <th>Estatus</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $jobs->links() }}
                    @foreach ($jobs->sortByDesc('id') as $job)
                        <tr>
                            <td style="width:30px"> <input type="checkbox" class="form-check-input"
                                wire:model.defer="selectedMotors" value="{{ $job->id }}"></td>
                            <td>
                                <div class="col-auto">
                                    @if ($job->images && $job->images->count() > 0 && Storage::exists('public' . $job->images->first()->image))
                                        <div class="avatar avatar-2xl">
                                            <img class="rounded-circle"
                                                src="{{ asset('storage' . $job->images->first()->image) }}"
                                                alt="" />
                                        </div>
                                    @else
                                        <div class="avatar avatar-2xl status-offline">
                                            <img class="rounded-circle"
                                                src="{{ asset('img/default-avatar.png') }}"
                                                alt="No hay foto" />
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center position-relative">
                                    {{--   --}}
                                    <div class="flex-1 ms-1">
                                        <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"
                                                href="{{ route('motors.showJob', $job) }}">{{ $job->fullos }}</a>
                                        </h6>
                                            <p class="text-500 fs--2 mb-0">{{ $job->jobType->name}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{$job->motor->cliente->cliente}}</td>
                            <td><a href="{{route('motores.show',$job->motor)}}">{{$job->motor->fullos}}</a></td>
                            <td>{{$job->motor->potencia}}</td>
                            <td> 
                                @if (!$job->finished)
                                <span class="badge badge-soft-danger">En Proceso</span>
                                @else
                                <span class="badge badge-soft-success">Terminado</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div>
                                    <a class="btn p-0" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" href="{{ route('motors.editJob', $job) }}">
                                        <span class="text-500 fas fa-edit"></span>
                                    </a>
                                    <button class="btn p-0 ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" onclick="eliminarTrabajo({{ $job->id }})">
                                        <span class="text-500 fas fa-trash-alt"> </span>
                                    </button>
                                   
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        eliminarTrabajo = function(id){
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('delete', id);
                    Swal.fire(
                        'Eliminado',
                        'El registro ha sido eliminado.',
                        'success'
                    );
                }
            });
        }
    </script>
</div>
