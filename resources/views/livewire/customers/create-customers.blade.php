<div>
    <x-page-title>
        <x-slot:title>Creacion de Cliente Nuevo</x-slot:title>
        Ingrese los datos del cliente
    </x-page-title>
    <div class="row">
        <div class="col-12 ">
            <x-form-card title="Informacion de Cliente">
                <div class="mb-3">
                    <label class="form-label" for="nombreCliente">Cliente</label>
                    <input class="form-control" id="nombreCliente" type="text" placeholder="Nombre Cliente" wire:model.defer="cliente"/>
                    @error('cliente') <div class="alert alert-danger my-1" role="alert">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nombreRazonSocial">Razon Social</label> 
                    <div class="btn btn-falcon-default me-2 mb-2" wire:click="setName">Usar Nombre Cliente</div>
                    <div class="btn btn-falcon-default me-2 mb-2" wire:click="setNameSA">Usar Nombre Cliente + S.A.</div>
                    <input class="form-control" id="nombreRazonSocial" type="text" placeholder="Cliente S.A." wire:model.defer="razon_social"/>
                    @error('razon_social') <div class="alert alert-danger my-1" role="alert">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nit">Nit</label>
                     <div class="btn btn-falcon-default me-2 mb-2" wire:click="setCF">C/F</div>
                    <input class="form-control" id="nit" type="text" placeholder="Nit" wire:model.defer="nit"/>
                    @error('nit') <div class="alert alert-danger my-1" role="alert">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="DireccionFiscal">Direccion Fiscal</label>
                    <div class="btn btn-falcon-default me-2 mb-2" wire:click="setCiudad">Usar Ciudad</div>
                    <input class="form-control" id="DireccionFiscal" type="text" placeholder="Direccion Fiscal" wire:model.defer="direccion_fiscal"/>
                    @error('direccion_fiscal') <div class="alert alert-danger my-1" role="alert">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="DireccionPlanta">Direccion Planta</label>
                    <div class="btn btn-falcon-default me-2 mb-2" wire:click="setPlantAddr">Usar direccion fiscal</div>
                    <input class="form-control" id="DireccionPlanta" type="text" placeholder="Direccion Planta" wire:model.defer="direccion_planta"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Pais">Pais</label>
                    <input class="form-control" id="Pais" type="text" value="Guatemala" wire:model.defer="pais"/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="ciudad">Ciudad</label>
                    <input class="form-control" id="ciudad" type="text" value="Guatemala" wire:model.defer="ciudad"/>
                </div>
                <div class=" mb-3">
                    <label class="form-label" for="InfoCliente">Informacion del Cliente</label>
                    <textarea name="" id="" cols="30" rows="10" class="form-control" wire:model.defer="comentarios"></textarea>
                  </div>
                
            </x-form-card>
        </div>
    </div>
    <div class="row">
        <div class="col-12 ">
            <x-form-card title="Guia de Contactos">
                <div class="row my-4">
                    <div class="col-6">
                        <div class="input-group flex-nowrap"><span class="input-group-text" id="addon-wrapping">No.
                                de Contactos</span>
                            <select class="form-select" aria-label="Default select example" wire:model="cant_contactos">
                                <option selected="">Seleccione Cantidad de Contactos</option>
                                @for ($i = 0; $i <= 6; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <button class="btn btn-outline-primary mx-3 mb-1" type="button" wire:click="addContact">Agregar Contacto
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($contactos as $key=>$contacto)
                        <div class="col-12 col-lg-6">
                            <x-form-card title="Contacto {{$key+1}}">
                                
                              
                                <div class="mb-3" wire:key="contactos_{{$key}}">
                                    <label class="form-label" for="InfoCliente">Nombre del Contacto</label>
                                    <input class="form-control" id="ciudad" type="text" value="Guatemala" wire:model.defer="contactos.{{$key}}.name"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Telefono">Telefono</label>
                                    <input class="form-control" type="text" wire:model.defer="contactos.{{$key}}.telefono"
                                        placeholder="Numero de Telefono" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Puesto">Puesto</label>
                                    <input class="form-control" type="text" wire:model.defer="contactos.{{$key}}.puesto"
                                        placeholder="Puesto en la empresa" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Email">Email</label>
                                    <input class="form-control" type="text" placeholder="Email" wire:model.defer="contactos.{{$key}}.email" />
                                </div>
                                <div >
                                    <button class="btn btn-danger me-1 mb-1 float-end" type="button" onclick="deleteContact({{$key}})">
                                        <i class="far fa-trash-alt me-1"></i> Borrar Contacto
                                    </button>
                                </div>
                            </x-form-card>
                        </div>
                    @endforeach
                </div>
            </x-form-card>
        </div>
    </div>
    <div class="bg-light clearfix px-2 py-1">
       
        <button type="button" class="btn btn-warning float-end m-2" wire:click="saveCustomer">Guardar Cliente</button>
        <button type="button" class="btn btn-primary float-end m-2">Cancelar</button>
    </div>
    <script src="{{asset('js/main.js')}}"></script>
    @push('livescripts')
     
    @endpush
</div>
