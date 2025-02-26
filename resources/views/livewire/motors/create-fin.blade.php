<div>
    <button class="btn btn-falcon-primary me-1 mb-1" type="button" style="font-size:12px" data-bs-toggle="modal"
        data-bs-target="#fin-modal">Finalizar</button>
    <div wire:ignore.self class="modal fade" id="fin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Finalizacion de Reparacion</h4>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label for="Foto">Foto de equipo finalizado</label>
                                    <button class="btn btn-falcon-primary me-1 mb-1" type="button"
                                        id="cameraBtnPhotoMotor3" wire:loading.attr="disabled" wire:target="photo"
                                        onclick="document.querySelector('#cameraPhotoMotor').click()">
                                        <div class="img-thumbnail">
                                            Cargue Foto Equipo Finalizado
                                        </div>
                                        <div wire:loading wire:target="photo">
                                            <div class="spinner-border" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <div wire:loading.remove wire:target="photo">
                                            @if ($photo != '')
                                                <img src="{{ $photo->temporaryUrl() }}" style="width:100%"
                                                    class="rounded-soft img-thumbnail">
                                            @else
                                                <img src="{{ asset('img/motors/m1.png') }}"
                                                    style="width:100%;filter: saturate(0);"
                                                    class="rounded-soft img-thumbnail filter-grayscale">
                                            @endif
                                        </div>
                                    </button>
                                    <input type="file" wire:model="photo" class="d-none" id="cameraPhotoMotor"
                                        accept="image/*">
                                </div>
                                @error('photo')
                                    <span class="error text-red-700">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <x-form-card title="Participacion de Tecnicos">
                                    <ul class="list-group">
                                        @foreach ($motor->tecnicos as $key => $tecnico)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $tecnico->name }}
                                                <input class="form-range" type="range" min="0" max="100"
                                                    step="1" wire:model="participacion.{{ $tecnico->id }}" />
                                                <span
                                                    class="badge bg-primary rounded-pill">{{ $participacion[$tecnico->id] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </x-form-card>
                                @if ($motor->ayudantes->count() > 0)
                                    <x-form-card title="Participacion de Ayudantes">
                                        <ul class="list-group">
                                            @foreach ($motor->ayudantes as $key => $ayudante)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $ayudante->name }}
                                                    <input class="form-range" type="range" min="0" max="100"
                                                        step="1" wire:model="participacionHelp.{{ $ayudante->id }}" />
                                                    <span
                                                        class="badge bg-primary rounded-pill">{{ $participacionHelp[$ayudante->id] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </x-form-card>
                                @endif
                                @if ($motor->horasExtras->count() > 0)
                                    <x-form-card title="Horas Extras en Proyecto">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-bordered table-hover ">
                                                    <thead class="bg-soft-primary" >
                                                        <tr>
                                                            <th scope="col">Fecha</th>
                                                            <th scope="col">Tecnico/Ayudante</th>
                                                            <th scope="col">Horas</th>
                                                            <th scope="col">Observaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($motor->horasExtras as $hora)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::parse($hora->init)->translatedFormat('l d \d\e F') }}</td>
                                                                <td>{{ $hora->user->name }}</td>
                                                                <td>{{ $hora->hours }}</td>
                                                                <td>{{ $hora->descripcion }}</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr style="background:#999">
                                                            <td colspan="4" style="text-align: center;color:white">
                                                                Total Horas: {{ $motor->horasExtras->sum('hours') }}
                                                            </td> 
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </x-form-card>
                                @endif
                                <x-form-card title="Tipo de Trabajo">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <select class="form-select" aria-label="Default select example" wire:model="tipo_trabajo_id">
                                                <option selected="">Seleccione el trabajo realizado</option>
                                                @foreach ($tipo_trabajos as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                                    
                                                @endforeach
                                              </select>
                                        </div>
                                    </div>
                                </x-form-card>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary close-modal" onclick="saveFin()" type="button">Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('livescripts')
    <script>
        function saveFin() {
            Swal.fire({
                title: '¿Estás seguro que deseas finalizar?',
                text: "Si finalizas no podrás hacer mas cambios en el motor",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, finalizar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('saveFin');
                }
            });
        }
        Livewire.on('motorFinalizado', function() {

            const contactModal = bootstrap.Modal.getInstance(document.getElementById('fin-modal'));
            contactModal.hide();
          
        })
    </script>
@endpush
