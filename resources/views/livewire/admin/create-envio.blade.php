<div>
    <x-page-title>
        <x-slot:title>Crear Documento de Env&iacute;o </x-slot:title>
        Este envio implica que el equipo sale de la empresa
    </x-page-title>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Fotograf&iacute;a Final </h5>

                </div>
                <div class="card-body">
                    <div class="row">
                        @if (isset($fotoFinal) && Storage::exists('public/' . $fotoFinal->foto))
                            <img class="img-thumbnail" src="{{ asset('storage/' . $fotoFinal->foto) }}" alt="Foto Final" />
                        @else
                            <img class="img-thumbnail" src="{{ asset('img/default-avatar.png') }}" alt="No hay foto" />
                        @endif
                        <button class="btn btn-falcon-primary me-1 mb-1 little-button" type="button"
                            onclick="loadCamera()">
                            <span><i class="fas fa-camera mx-1"></i> Cambiar Foto</span></a>
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Datos del Piloto</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <select class="form-select" aria-label="Default select example" wire:model="selectedPiloto">
                                <option selected="">Seleccione el Piloto</option>
                                @foreach ($pilotosDB as $piloto)
                                    <option value="{{ $piloto->id }}">{{ $piloto->name }}</option>
                                @endforeach
                                <option value="0">Otro</option>

                            </select>
                            <div>
                                <label class="form-label" for="Piloto">Nombre del Piloto</label>
                                <input class="form-control" id="Piloto" type="text"
                                    placeholder="Nombre del Piloto" name="piloto" wire:model="piloto" />
                                <label class="form-label" for="Piloto">DPI Piloto</label>
                                <input class="form-control" id="dpiPiloto" type="text" placeholder="DPI del Piloto"
                                    name="dpi" wire:model="dpi" />
                                @if ($selectedPiloto == 0)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            value="" />
                                        <label class="form-check-label" for="flexCheckDefault">Guardar Piloto</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <select class="form-select" aria-label="Default select example"
                                wire:model="selectedVehiculo">
                                <option selected="">Seleccione el Vehiculo</option>
                                @foreach ($vehiculosDB as $vehiculo)
                                    <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }}</option>
                                @endforeach
                                <option value="0">Otro</option>
                            </select>
                            <div>
                                <label class="form-label" for="tipoVehilculo">Tipo de Vehiculo</label>
                                <input class="form-control" id="tipoVehilculo" type="text"
                                    placeholder="Tipo de Vehiculo" name="tipoVehiculo" wire:model="tipo_vehiculo" />
                                <label class="form-label" for="placa">Placa</label>
                                <input class="form-control" id="placa" type="text" placeholder="Placa"
                                    wire:model="placa" name="placa" />

                                @if ($selectedVehiculo == 0)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            value="" />
                                        <label class="form-check-label" for="flexCheckDefault">Guardar Vehiculo</label>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="card-title">Partes adicionales a ser entregadas</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <div class="form-check form-switch me-3">
                                    <input class="form-check-input" id="flexSwitchCheckChecked1" type="checkbox"
                                        checked="" wire:model="agregarCojinetes"/>
                                    <label class="form-check-label" for="flexSwitchCheckChecked1">Cojinetes en mal
                                        estado</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="flexSwitchCheckChecked2" type="checkbox"
                                        checked="" wire:model="agregarRetenedores" />
                                    <label class="form-check-label" for="flexSwitchCheckChecked2">Retenedores en mal
                                        estado</label>
                                </div>
                            </div>
                        </div>
                        <form wire:submit.prevent="addPart">
                            <div class="row">
                                <label class="form-label" for="exampleFormControlInput1">Parte o item</label>
                                <div class="col-12 d-flex justify-content-between">
                                    <input class="form-control" id="exampleFormControlInput1" type="text"
                                        placeholder="Parte adicional" wire:model="newPart"/>
                                    <button class="btn btn-primary mx-1 mb-1" type="submit">Agregar</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="10%">Item</th>
                                            <th scope="col">Parte</th>
                                            <th class="text-end" scope="col">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0
                                        @endphp
                                        @foreach ($partes as $parte)
                                            @if ($parte != "")
                                                @php $count++ @endphp
                                                <tr>
                                                    <td>{{ $count }}</td>
                                                    <td>{{ $parte }}</td>
                                                    <td class="text-end">
                                                        <button class="btn btn-danger btn-sm" type="button" wire:click="removeParte({{ $loop->index }})">Eliminar</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="card-title">Observaciones</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    wire:model="observaciones"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card  mb-3">
                   
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-falcon-danger me-1 mb-1" type="button" wire:click="generatePDF">
                            <i class="fas fa-file-pdf"></i> Guardar y Generar PDF
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
