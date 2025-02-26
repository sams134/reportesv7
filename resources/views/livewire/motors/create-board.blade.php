<div>
    <button class="btn btn-outline-success mx-2 mb-1" type="button" data-bs-toggle="modal"
        data-bs-target="#newBoard-modal">Crear nuevo tablero
    </button>



    <div wire:ignore.self class="modal fade" id="newBoard-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 30%">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">Nuevo Tablero</h4>
                        </div>
                        <div class="p-4 pb-0">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Nombre del nuevo
                                        tablero:</label>
                                    <input class="form-control" id="exampleFormControlInput1" type="text"
                                        placeholder="Nombre del tablero, Ej. Motores en estanteria"
                                        wire:model.defer="name" />
                                    @error('name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('livescripts')
    <script>
        Livewire.on('boardStored', function() {

            const contactModal = bootstrap.Modal.getInstance(document.getElementById('newBoard-modal'));
            contactModal.hide();
            Swal.fire({
                title: "Tablero Creado",
                text: "Ahora puedes agregar motores a este tablero",
                icon: "success"
            });
        })
    </script>
@endpush
