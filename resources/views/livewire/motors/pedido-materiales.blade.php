<div>
    <button class="btn btn-falcon-primary me-1 mb-1" type="button" data-bs-toggle="modal"
        data-bs-target="#pedidoMateriales">
        <span><i class="far fa-list-alt mx-1"></i> Pedir Materiales </span></a>
    </button>
    <div  wire:ignore.self class="modal fade" id="pedidoMateriales" tabindex="-1" aria-labelledby="pedidoMaterialesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 80%">
            <div class="modal-content">
                <div class="modal-header bg-falcon-primary text-white">
                    <h5 class="modal-title" id="pedidoMaterialesLabel">Pedido de Materiales</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-1 col-sm-3">
                            <div class="form-group mb-3">
                                <label for="material">Cantidad</label>
                                <input type="number" step="0.01" class="form-control" id="material" wire:model.defer="cant"
                                    placeholder="Cantidad">
                                @error('cantidad')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 col-sm-9">
                            <div class="form-group mb-3">
                                <label for="material">Presentacion</label>
                                <input type="text" class="form-control" id="material" wire:model.defer="presentacion"
                                    placeholder="Presentacion, Ej, Dividido 3 carretes, en yardas, pliegos, etc">
                                @error('presentacion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 col-sm-10">
                            <div class="form-group mb-3">
                                <label for="material">Material</label>
                                <input type="text" class="form-control" id="material" wire:model.defer="material"
                                    placeholder="Material">
                                @error('material')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-2 col-sm-2">
                            <div class="form-group mb-3">
                                <button class="btn btn-primary me-1 mt-4" type="button" wire:click="addMaterial">Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                    @livewire('motors.show-pedido', ['motor' => $motor])
                </div>
     
            <div class="modal-footer">
                <button type="button" class="btn btn-falcon-primary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>

</div>
