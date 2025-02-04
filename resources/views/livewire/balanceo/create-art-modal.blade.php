<div>

    <button class="btn btn-outline-primary me-1 mb-1" type="button" data-bs-toggle="modal"
        data-bs-target="#newArt-modal">Cargar nuevo arte</button>



    <div wire:ignore.self class="modal fade" id="newArt-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 50%">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Agregar Nuevo Arte </h4>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="Archivo Arte">Archivo Arte</label>
                                    <input type="file" class="form-control" wire:model="file" id="file"
                                        name="file" accept=".png, .jpg">
                                    @error('file')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="preview">Vista Previa</label>
                                    <div>
                                        @if ($file)
                                            <img src="{{ $file->temporaryUrl() }}" alt="Vista Previa"
                                                class="img-thumbnail" style="max-width: 100%;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary close-modal" wire:click.prevent="store()" type="button">Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('livescripts')
    <script>
        Livewire.on('artCreated', function() {

            const contactModal = bootstrap.Modal.getInstance(document.getElementById('newArt-modal'));
            contactModal.hide();
            Swal.fire({
                title: "Arte Creado",
                text: "El arte ha sido creado exitosamente",
                icon: "success"
            });
        })
    </script>
@endpush
