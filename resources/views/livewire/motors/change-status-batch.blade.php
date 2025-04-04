<div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="statusBatchModal" tabindex="-1" aria-labelledby="statusBatchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusBatchModalLabel">Cambiar el estatus de varios equipos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Modal content goes here -->
                    <label for="escoja">Escoja el estatus que tendran todos los equipos</label>
                    <select class="form-select" aria-label="Default select example" wire:model.defer="newStatus">
                        <option selected="">Seleccione Estatus</option>
                         @foreach ($statuses as $status)
                        <option value="{{$status->id}}">{{$status->status}} </option>
                         @endforeach
                      </select>
                      @error('newStatus') <span class="text-danger">Seleccione el nuevo estatus</span> @enderror
                    <ul class="list-group mt-3">
                        @if ($motorIds)
                        @foreach ($motors as $motor)
                        <li class="list-group-item d-flex justify-content-between align-items-center"><strong>{{$motor->cliente->cliente}}<small>{{$motor->fullOs}}</small></strong>
                            <x-status-badge status_id="{{ $motor->status_id }}"/></li>
                        @endforeach
                       @endif
                       
                      </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('show-modal-status-batch', () => {
                console.log('entro a listener de abrir');
                var modal = new bootstrap.Modal(document.getElementById('statusBatchModal'));
                modal.show();
            });

            Livewire.on('hide-modal-status-batch', () => {
                var modal = bootstrap.Modal.getInstance(document.getElementById('statusBatchModal'));
                modal.hide();
            });
            Livewire.on('status-changed', (cantidadMotores) => {
                Swal.fire({
                    title: 'Estatus Actualizado',
                    text: `Se actualizó el estatus de ${cantidadMotores} motores.`,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            });
            });
    
    </script>
</div>
