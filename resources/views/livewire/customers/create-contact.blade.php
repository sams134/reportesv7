<div>
    <button class="btn btn-primary mt-3" type="button" data-bs-toggle="modal" data-bs-target="#newContact-modal">Nuevo Contacto</button>
    <div wire:ignore.self class="modal fade" id="newContact-modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <div class="mb-3" >
                                <label class="form-label" for="InfoCliente">Nombre del Contacto</label>
                                <input class="form-control" id="ciudad" type="text" value="" placeholder="Pedro Perez" wire:model.defer="name"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Telefono">Telefono</label>
                                <input class="form-control" type="text" wire:model.defer="telefono"
                                    placeholder="5555-8888" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Puesto">Puesto</label>
                                <input class="form-control" type="text" wire:model.defer="puesto"
                                    placeholder="Gerente de Mantenimiento" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="Email">Email</label>
                                <input class="form-control" type="text" placeholder="pedro.perez@email.com" wire:model.defer="email" />
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary close-modal" wire:click.prevent="store()" type="button">Guardar </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('livescripts')
     <script>
        
        </script>
@endpush
