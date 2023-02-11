<div>



    <button class="btn btn-warning me-1 mb-1" type="button" data-bs-toggle="modal"
        data-bs-target="#editContact-modal_{{ $contacto->id }}">
        <i class="far fa-edit me-1"></i>
    </button>


    <div class="modal fade" id="editContact-modal_{{ $contacto->id }}" tabindex="-1" role="dialog" aria-hidden="true"
        wire:key="contacto_{{ $contacto->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Agregar Nuevo Contacto </h4>
                    </div>
                    <div class="p-4 pb-0">
                        <form>
                            <div class="mb-3">
                                <label class="form-label" for="InfoCliente">Nombre del Contacto</label>
                                <input class="form-control" id="ciudad" type="text" value=""
                                    placeholder="Pedro Perez" wire:model.defer="contacto.contacto" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Telefono">Telefono</label>
                                <input class="form-control" type="text" wire:model.defer="contacto.telefono"
                                    placeholder="5555-8888" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Puesto">Puesto</label>
                                <input class="form-control" type="text" wire:model.defer="contacto.puesto"
                                    placeholder="Gerente de Mantenimiento" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Email">Email</label>
                                <input class="form-control" type="text" placeholder="pedro.perez@email.com"
                                    wire:model.defer="contacto.email" />
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary close-modal" wire:click.prevent="save" type="button"
                        wire:loading.attr="disabled">Guardar </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('livescripts')
    <script>
        Livewire.on('closeEditedContact', function($id) {
            const contactModal = bootstrap.Modal.getInstance(document.getElementById('editContact-modal_' + $id));
            contactModal.hide();
        })
        Livewire.on('alert', function($message) {
            Swal.fire(
                'Notificacion',
                $message,
                'success'
            )
        })
    </script>
@endpush
