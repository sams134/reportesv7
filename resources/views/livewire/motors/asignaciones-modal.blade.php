<div wire:ignore.self class="modal fade" id="asignacionesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                @if (!$motor)
                    <h1>No se seleccionó equipo</h1>
                @else
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Asignar la OS {{ $motor->fullOs }}</h4>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="row">
                            <x-pretty-card title="Datos del cliente">
                                <div class="">
                                    <div class="row">
                                        <h5 class="mb-0">Estatus Actual</h5>
                                        <p class="mb-0">El estatus actual de la OS es: <x-status-badge
                                                status_id="{{ $motor->status_id }}" /></p>
                                    </div>
                                    <div class="row">
                                        <select class="form-select my-3" aria-label="Default select example" wire:model="newStatus" wire:change="updateStatus">
                                            @foreach ($statuses as $item)
                                                <option value="{{$item->id}}">{{$item->status}} </option>
                                            @endforeach
                                        </select>  
                                    </div>
                                </div>
                            </x-pretty-card>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <x-pretty-card>
                                    <div class="table-responsive scrollbar" style="max-height: 60vh; overflow-y: auto;">
                                        <h3>Listado de Técnicos</h3>
                                        <table class="table table-hover">
                                            @foreach ($tecnicos as $tecnico)
                                                <tr>
                                                    <td style="width:70px">
                                                        <img src="{{ asset($tecnico->foto) }}" alt="" class="avatar" style="max-height: 80px; max-width: 50px;">
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <!-- Se usa una clave única para cada técnico en el array tecnicoSelected -->
                                                            <input class="form-check-input" id="flexSwitchCheckDefault_{{ $tecnico->id }}" type="checkbox"
                                                                wire:model="tecnicoSelected.{{ $tecnico->id }}" />
                                                            <label class="form-check-label" for="flexSwitchCheckDefault_{{ $tecnico->id }}">
                                                                {{ $tecnico->name }}
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </x-pretty-card>
                            </div>
                            <div class="col-12 col-sm-6">
                                <x-pretty-card>
                                    <div class="table-responsive scrollbar" style="max-height: 60vh; overflow-y: auto;">
                                        <h3>Listado de Ayudantes</h3>
                                        <table class="table table-hover">
                                            @foreach ($ayudantes as $tecnico)
                                                <tr>
                                                    <td style="width:70px">
                                                        <img src="{{ asset($tecnico->foto) }}" alt="" class="avatar" style="max-height: 80px; max-width: 50px;">
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <!-- Se usa una clave única para cada técnico en el array tecnicoSelected -->
                                                            <input class="form-check-input" id="flexSwitchCheckDefault_{{ $tecnico->id }}" type="checkbox"
                                                                wire:model="ayudanteSelected.{{ $tecnico->id }}" />
                                                            <label class="form-check-label" for="flexSwitchCheckDefault_{{ $tecnico->id }}">
                                                                {{ $tecnico->name }}
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </x-pretty-card>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary close-modal" wire:click.prevent="saveAsignaciones()" type="button">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    if (!window.modalListenerAttached) {
        window.modalListenerAttached = true;

        window.addEventListener('show-modal', event => {
            console.log('Evento "show-modal" recibido');
            var modalElement = document.getElementById('asignacionesModal');
            var modal = bootstrap.Modal.getInstance(modalElement);
            if (!modal) {
                modal = new bootstrap.Modal(modalElement);
            }
            modal.show();
        });

        document.getElementById('asignacionesModal').addEventListener('hidden.bs.modal', function () {
            var backdrops = document.getElementsByClassName('modal-backdrop');
            while (backdrops.length > 0) {
                backdrops[0].parentNode.removeChild(backdrops[0]);
            }
        });
        window.addEventListener('hide-modal', event => {
            console.log('Evento "hide-modal" recibido');
            var modalElement = document.getElementById('asignacionesModal');
            var modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
            modal.hide();
            }
        });
    }
</script>