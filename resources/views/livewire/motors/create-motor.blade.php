@php
    use Carbon\Carbon;
    Carbon::setLocale('es');
@endphp
<div class="">
    <x-page-title>
        <x-slot:title>Nueva Orden de Servicio</x-slot:title>
        Ingrese los datos del equipo.
    </x-page-title>

    <div class="col-lg-12 col-xl-12 col-xxl-12 h-100">

        <x-form-wizzard active="{{ $step + 1 }}">
            <x-slot:tab1>

                <div class="row">

                    <div class="col-12 col-lg-6">
                        <x-form-card title="Datos del cliente">
                            <div>
                                <label class="d-flex flex-row">Cliente

                                    @livewire('customers.create-customer-modal')
                                </label>
                                <select class="form-select" size="1" wire:model="customer_id"
                                    wire:change="fillContacts">
                                    <option value="">Seleccione un Cliente</option>
                                    @foreach ($clientesList as $cliente)
                                        <option value="{{ $cliente->id_cliente }}">{{ $cliente->cliente }}</option>
                                    @endforeach
                                </select>
                                @error('cliente')
                                    <div class="alert alert-danger my-1 py-1" role="alert"> {{ $message }}</div>
                                @enderror
                            </div>

                            @if (sizeof($contactList) > 0)
                                <div class="mt-3">
                                    <span>Informar a los siguientes contactos de la organizacion:</span>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th><input class="form-check-input" type="checkbox" value="" />
                                                </th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contactList as $contact)
                                                <tr>
                                                    <td> <input class="form-check-input" type="checkbox"
                                                            wire:model="emailTo" value="{{ $contact->id }}" /></td>
                                                    <td>{{ $contact->contacto }}</td>
                                                    <td>{{ $contact->email }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            @endif
                            @if ($customer_id != '')
                                @livewire('customers.create-contact', ['id_cliente' => $customer->id_cliente])
                            @endif

                        </x-form-card>
                    </div>
                    <div class="col-12 col-lg-6">
                        <x-form-card title="Datos del servicio">
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">2M-</span>
                                        <input class="form-control" type="text" wire:model="year" />
                                        @error('year')
                                        <div class="alert alert-danger my-1 py-1" role="alert"> {{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>-
                                <div class="col-6">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">OS</span>
                                        <input class="form-control" type="text" wire:model="os">
                                        @error('os')
                                            <div class="alert alert-danger my-1 py-1" role="alert"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label" for="datepicker">Fecha de Ingreso</label>
                                <input class="form-control datetimepicker"" type="text" wire:model="inDate" " data-options='{"disableMobile":true,"dateFormat": "d-m-Y"}' />
                             
                            </div>
                            <div class="mt-3">
                                <div class="form-check form-switch">

                                    <input class="form-check-input"  type="checkbox" wire:model="preAutorizado" />
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Equipo
                                        pre-Autorizado</label>
                                       
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Nivel de Emergencia</label>
                                <select class="form-select" wire:model="emergencyLevel">
                                    <option selected="">Seleccione nivel de Emergencia</option>
                                    <option value="1">Bajo</option>
                                    <option value="2">Medio</option>
                                    <option value="3">Alto</option>
                                    <option value="4">Muy Alto (+ Costo adicional 10%)</option>
                                </select>
                                
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlTextarea1">Comentarios del
                                    cliente</label>
                                <textarea class="form-control" rows="3" wire:model="comentariosCliente"></textarea>
                                
                            </div>
                        </x-form-card>
                    </div>
                </div>
            </x-slot:tab1>
            <x-slot:tab2>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <x-form-card title="Datos del equipo">
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Nombre del equipo en planta</label>
                                <input class="form-control"  type="text"  wire:model="equipmentName"/>
                              </div>
                              <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Tipo de Equipo</label>
                                <select class="form-select" aria-label="Default select example" wire:model="equipmentType">
                                    <option selected="">Seleccione tipo de equipo</option>
                                           @foreach ($equipmentTypes as $types)
                                <option value="{{ $types->id }}">{{ $types->name }}</option>
                                @endforeach
                                </select>
                                @error('tipo_equipo')
                                <div class="alert alert-danger my-1 py-1" role="alert"> {{ $message }}</div>
                            @enderror
                            </div>
                        </x-form-card>
                        <x-form-card title="Fotos de Placa">
                            <span class="mb-3">
                                Cargue las fotos de todas las placas de datos del equipo.
                            </span>
                            <button class="btn btn-falcon-primary m-2" type="button" id="cameraBtnNameplate">
                                <i class="fas fa-camera"></i> Cargar foto(s) de placa
                            </button>
                            <div class="alert alert-warning align-middle" role="alert" wire:loading
                                wire:target="nameplates">
                                <div class="spinner-border" role="status"><span
                                        class="visually-hidden">Loading...</span></div>
                                <span class="mt-4">
                                    Espere mientras se carga la imagen
                                </span>

                            </div>
                            @foreach ($nameplates as $key => $foto)
                                <div class="col-12">
                                    <img src="{{ $foto->temporaryUrl() }}" style="width:100%"
                                        class="rounded-soft img-thumbnail">
                                    <button class="btn btn-danger me-1 mb-1" type="button"
                                        wire:click="removeNameplate({{ $key }})">
                                        <i class="far fa-trash-alt me-1"></i>Borrar Foto
                                    </button>

                                </div>
                            @endforeach

                            <input type="file" wire:model="nameplates" class="d-none"  accept="image/*" id="cameraNameplate">
                        </x-form-card>
                    </div>
                    <div class="col-12 col-lg-6">
                        <x-form-card title="Datos de Placa">
                            <div class="mb-1 row">
                                <div class="col-9">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Potencia</span>
                                        <input class="form-control" type="text" placeholder="100"
                                            wire:model="potencia" />
                                        @error('hp')
                                            <div class="alert alert-danger my-1 py-1" role="alert"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3 pt-2">
                                    <div class="form-check form-switch align-bottom">
                                        <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox"
                                            wire:model="aproximado" />
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Aprox.</label>
                                    </div>
                                </div>
                                <div class="mt-n2 fs-1 text-muted">
                                    <small class="text-black-50">* Utilice Aprox, si no tiene a la vista la
                                        placa</small>
                                </div>
                            </div>
                            <div class="mb-3 row ps-5">

                                <div class="form-check col-4">
                                    <input class="form-check-input" type="radio" value="0"
                                        wire:model="powerUnit" />
                                    <label class="form-check-label">HP</label>
                                </div>
                                <div class="form-check col-4">
                                    <input class="form-check-input" type="radio" value="1"
                                        wire:model="powerUnit" />
                                    <label class="form-check-label">KW</label>
                                </div>
                                <div class="form-check col-4">
                                    <input class="form-check-input" type="radio" value="2"
                                        wire:model="powerUnit" />
                                    <label class="form-check-label">KVA</label>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Rpm</span>
                                        <input class="form-control" type="text" placeholder="eg. 1770"
                                            wire:model="rpm" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Marca</span>
                                        <input class="form-control" type="text"
                                            placeholder=" eg. General Electric / Weg / Siemens" wire:model="marca"
                                            style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">No. Serie</span>
                                        <input class="form-control" type="text" placeholder="xxxx"
                                            wire:model="serie" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">No. Modelo</span>
                                        <input class="form-control" type="text" placeholder="xxxx"
                                            wire:model="modelo" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Voltajes</span>
                                        <input class="form-control" type="text" placeholder="eg. 208-230/460"
                                            wire:model="voltaje" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Amperajes</span>
                                        <input class="form-control" type="text" placeholder="eg. 11.5-12/6"
                                            wire:model="amperaje" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Frame</span>
                                        <input class="form-control" type="text" placeholder="eg. 256TZ / 132M"
                                            wire:model="frame" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Factor de Potencia</span>
                                        <input class="form-control" type="text" placeholder="0.85"
                                            wire:model="pf" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Eficiencia</span>
                                        <input class="form-control" type="text" placeholder="93%"
                                            wire:model="eff" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-12">
                                    <div class="input-group mb-3"><span class="input-group-text"
                                            id="basic-addon1">Hz.</span>
                                        <input class="form-control" type="text" placeholder="eg. 60"
                                            wire:model="hz" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pt-2">
                                <div class="form-check form-switch align-bottom">
                                    <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox"
                                        wire:model="inverter" />
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Inverter Duty</label>
                                </div>
                            </div>

                        </x-form-card>
                    </div>
                </div>
            </x-slot:tab2>
            <x-slot:tab3>
                <div class="col-12">
                    <x-form-card title="Inventario">
                        <table class="table table-hover">
                            <colgroup>
                                <col class="bg-soft-primary" style="width:20%" />
                                <col class="" />

                            </colgroup>
                            <tbody>
                                @foreach ($inventory as $key => $part)
                                    <tr>
                                        <td>{{ $part['name'] }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            value="1"
                                                            wire:model="inventory.{{ $key }}.valor" />
                                                        <label class="form-check-label">Buen Estado</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            value="2"
                                                            wire:model="inventory.{{ $key }}.valor" />
                                                        <label class="form-check-label">Mal Estado</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            value="3"
                                                            wire:model="inventory.{{ $key }}.valor" />
                                                        <label class="form-check-label">No trae</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            value="4"
                                                            wire:model="inventory.{{ $key }}.valor" />
                                                        <label class="form-check-label">No Aplica</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <label class="form-label" for="exampleFormControlTextarea1">Comentarios del
                                inventario</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="inventoryComments"></textarea>
                        </div>
                    </x-form-card>
                </div>
                <div class="col-12">
                    <x-form-card title="Fotos Partes Dañdas o Faltantes">
                        <div class="row">
                            <div class="col-3">
                                <button id="cameraBtnModal" class="p-4 btn btn-outline-warning"
                                    wire:loading.attr="disabled" wire:target="photoInventory,removeImage">
                                    <div wire:loading.remove wire:target="photoInventory">
                                        <i class="fas fa-camera fs-6"></i>
                                        <div>Agregue fotos</div>
                                    </div>
                                    <div class="spinner-border" role="status" wire:loading
                                        wire:target="photoInventory">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                </button>
                            </div>

                            @foreach ($photoInventory as $key => $foto)
                                <div class="col-3">
                                    <img src="{{ $foto->temporaryUrl() }}" style="width:100%"
                                        class="rounded-soft img-thumbnail">
                                    <button class="btn btn-danger me-1 mb-1" type="button"
                                        wire:click="removeImage({{ $key }})">
                                        <i class="far fa-trash-alt me-1"></i>Borrar Foto
                                    </button>

                                </div>
                            @endforeach

                        </div>
                        <input type="file" wire:model="photoInventory" class="d-none"  accept="image/*" id="cameraModal">
                    </x-form-card>
                </div>
            </x-slot:tab3>
            <x-slot:tab4>
                    <x-form-card title="Cargue 4 fotos del equipo">
                        <div class="row">
                            <div class="col-6 col-lg-3">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button"
                                    id="cameraBtnPhotoMotor1">
                                    <div class="img-thumbnail">
                                        Cargue Foto Vista 1
                                    </div>
                                    @if ($photosMotor[0] != '')
                                        <img src="{{ $photosMotor[0]->temporaryUrl() }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @else
                                        <img src="{{ asset('img/motors/m1.png') }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @endif

                                </button>
                            </div>
                            <div class="col-6 col-lg-3">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button"
                                    id="cameraBtnPhotoMotor2">
                                    <div class="img-thumbnail">
                                        Cargue Foto Vista 2
                                    </div>
                                    @if ($photosMotor[1] != '')
                                        <img src="{{ $photosMotor[1]->temporaryUrl() }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @else
                                        <img src="{{ asset('img/motors/m2.png') }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @endif
                                </button>
                            </div>
                            <div class="col-6 col-lg-3">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button"
                                    id="cameraBtnPhotoMotor3">
                                    <div class="img-thumbnail">
                                        Cargue Foto Vista 3
                                    </div>
                                    @if ($photosMotor[2] != '')
                                        <img src="{{ $photosMotor[2]->temporaryUrl() }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @else
                                        <img src="{{ asset('img/motors/m3.png') }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @endif
                                </button>
                            </div>
                            <div class="col-6 col-lg-3">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button"
                                    id="cameraBtnPhotoMotor4">
                                    <div class="img-thumbnail">
                                        Cargue Foto Vista 4
                                    </div>
                                    @if ($photosMotor[3] != '')
                                        <img src="{{ $photosMotor[3]->temporaryUrl() }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @else
                                        <img src="{{ asset('img/motors/m4.png') }}" style="width:100%"
                                            class="rounded-soft img-thumbnail">
                                    @endif
                                </button>
                            </div>
                        </div>
                        <input type="file" wire:model="photosMotor.0" class="d-none" id="cameraPhotoMotor1"  accept="image/*">
                        <input type="file" wire:model="photosMotor.1" class="d-none" id="cameraPhotoMotor2"  accept="image/*">
                        <input type="file" wire:model="photosMotor.2" class="d-none" id="cameraPhotoMotor3"  accept="image/*"> 
                        <input type="file" wire:model="photosMotor.3" class="d-none" id="cameraPhotoMotor4"  accept="image/*">
                    </x-form-card>
                </x-slot:tab4>
                <x-slot:tab5>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <x-form-card title="Resumen Orden de trabajo">
                                <h1>{{ $year }}-{{ $os }}</h1>
                                @if ($customer)
                                    <h3>{{ $customer->cliente }}</h3>
                                @endif
                                <div class="card border h-100 border-primary">
                                    <div class="card-body">
                                        <div class="card-title">Se Informara a los siguientes contactos</div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($emailToReal as $item)
                                                    <tr>
                                                        <td>{{ $item['contacto'] }}</td>
                                                        <td>{{ $item['email'] }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card border h-100 border-primary mt-2">
                                    <div class="card-body">
                                        <div class="card-title">Informacion de la OS</div>
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Fecha Ingreso:</td>
                                                    <td>{{ $fechaSpanish }} <br>
                                                    {{$inDate}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Equipo pre-autorizado:</td>
                                                    <td>{{ $preAutorizado ? 'Sí, pre-autorizado' : 'No, enviar cotización' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Nivel de Emergencia:</td>
                                                    <td>
                                                        @switch($emergencyLevel)
                                                            @case(1)
                                                                <p>Bajo</p>
                                                            @break

                                                            @case(2)
                                                                <p>Medio</p>
                                                            @break

                                                            @case(3)
                                                                <p>Alto</p>
                                                            @break

                                                            @case(4)
                                                                <p>Muy Alto (+ Costo adicional 10%)</p>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Comentarios del Cliente:</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $comentariosCliente }}</p>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </x-form-card>
                            <x-form-card title="Resumen de datos del equipo">
                                <div class="card border h-100 border-primary">
                                    <div class="card-body">
                                        <div class="card-title">Placa de Datos</div>
                                        @if (!empty($nameplates))
                                            @foreach ($nameplates as $key => $foto)
                                                <div class="col-3">
                                                    <img src="{{ $foto->temporaryUrl() }}" style="width:100%"
                                                        class="rounded-soft img-thumbnail">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-3">
                                                <div class="rounded-soft img-thumbnail d-flex flex-column justify-content-center align-items-center"
                                                    style="width:100%; height:100%;">
                                                    <i class="fas fa-image" style="font-size: 5rem;"></i>
                                                    <p class="text-center mt-3">No hay placa</p>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="mt-2">
                                            <style>
                                                #placa td {
                                                    padding: 0.3rem;
                                                }
                                            </style>

                                            <div class="table-responsive scrollbar">
                                                <table class="table table-bordered overflow-hidden" id="placa">
                                                    <colgroup>
                                                        <col class="bg-soft-primary" />
                                                        <col />
                                                        <col class="bg-soft-primary" />
                                                        <col />
                                                    </colgroup>

                                                    <tbody>

                                                        <tr class="">
                                                            <td>Area de Equipo:</td>
                                                            <td colspan="3">
                                                                <p class="text-capitalize">{{ $equipmentName }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr class="">
                                                            <td>Tipo de Equipo:</td>
                                                            <td colspan="3">
                                                                <strong>{{ $selectedEquipmentTypeName }}</strong></td>

                                                        </tr>
                                                        <tr class="">
                                                            <td>Potencia:</td>
                                                            <td>
                                                                {{ $aproximado ? "~ $potencia" : "$potencia" }}
                                                                @switch($powerUnit)
                                                                    @case(1)
                                                                        HP
                                                                    @break

                                                                    @case(2)
                                                                        KW
                                                                    @break

                                                                    @case(3)
                                                                        KVA
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                            </td>
                                                            <td>Rpm:</td>
                                                            <td>{{ $rpm }}</td>
                                                        </tr>
                                                        <tr class="">
                                                            <td>Marca:</td>
                                                            <td>{{ $marca }}</td>
                                                            <td>Numero de serie:</td>
                                                            <td>{{ $serie }}</td>
                                                        </tr>
                                                        <tr class="">
                                                            <td>Voltajes:</td>
                                                            <td>{{ $voltaje }}</td>
                                                            <td>Amperajes:</td>
                                                            <td>{{ $amperaje }}</td>
                                                        </tr>
                                                        <tr class="">
                                                            <td>Modelo</td>
                                                            <td>{{ $modelo }}</td>
                                                            <td>Frame</td>
                                                            <td>{{ $frame }}</td>
                                                        </tr>
                                                        <tr class="">
                                                            <td>Hz</td>
                                                            <td>{{ $hz }}</td>
                                                            <td>Inverter Duty</td>
                                                            <td> <strong>{{ $inverter ? 'Inverter Duty' : '' }}</strong>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>

                                    </div>
                                </div>
                            </x-form-card>
                        </div>
                        <div class="col-12 col-lg-6">
                            <x-form-card title="Resumen de Inventario">
                                <div class="card border h-100 border-primary">
                                    <div class="card-body">
                                        <div class="card-title">Partes dañadas o faltantes</div>
                                        @if (!empty($photoInventory))
                                            @foreach ($photoInventory as $key => $foto)
                                                <div class="col-3">
                                                    <img src="{{ $foto->temporaryUrl() }}" style="width:100%"
                                                        class="rounded-soft img-thumbnail">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12">
                                                <p>Afortunadamente no hay partes faltantes o dañadas</p>
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <style>
                                                #placa td {
                                                    padding: 0.3rem;
                                                }
                                            </style>
                                            @php
                                                function getStatusString($value)
                                                {
                                                    switch ($value) {
                                                        case 1:
                                                            return 'Buen Estado';
                                                        case 2:
                                                            return 'Mal estado';
                                                        case 3:
                                                            return 'No trae';
                                                        case 4:
                                                            return 'N/A';
                                                        default:
                                                            return $value;
                                                    }
                                                }
                                            @endphp
                                            <div class="table-responsive scrollbar">
                                                <table class="table table-bordered overflow-hidden" id="placa">
                                                    <colgroup>
                                                        <col class="bg-soft-primary" />
                                                        <col />
                                                        <col class="bg-soft-primary" />
                                                        <col />
                                                    </colgroup>
                                                    <tbody>
                                                        @for ($i = 0; $i < count($inventory); $i += 2)
                                                            <tr class="">
                                                                <td>{{ $inventory[$i]['name'] }}</td>
                                                                <td>
                                                                    <p class="text-capitalize">
                                                                        {{ getStatusString($inventory[$i]['valor']) }}
                                                                    </p>
                                                                </td>
                                                                @if ($i + 1 < count($inventory))
                                                                    <td>{{ $inventory[$i + 1]['name'] }}</td>
                                                                    <td>
                                                                        <p class="text-capitalize">
                                                                            {{ getStatusString($inventory[$i + 1]['valor']) }}
                                                                        </p>
                                                                    </td>
                                                                @else
                                                                    <td></td>
                                                                    <td></td>
                                                                @endif
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-form-card>
                            <x-form-card title="Resumen de Inventario">
                                <div class="card border h-100 border-primary">
                                    <div class="card-body">
                                        <div class="card-title">Partes dañadas o faltantes</div>
                                           <div class="row">
                                          
                                                @for($i=0;$i<4;$i++)
                                            
                                                    @if ($photosMotor[$i]!='')
                                                        <div class="col-6">
                                                            <img src="{{ $photosMotor[$i]->temporaryUrl() }}" style="width:100%"
                                                                class="rounded-soft img-thumbnail">
                                                        </div>
                                                    @else
                                                        <div class="col-6">
                                                            <div class="rounded-soft img-thumbnail d-flex flex-column justify-content-center align-items-center"
                                                            style="width:100%; height:100%;">
                                                            <img src="{{ asset('img/motors/m'.($i+1).'.png') }}" style="width:100%;filter: saturate(0);"
                                                            class="rounded-soft img-thumbnail filter-grayscale">
                                                                <p class="text-center mt-3">No hay fotos del equipo</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endfor
                                        </div>
                                       
                                    </div>
                                </div>
                            </x-form-card>
                        </div>

                    </div>
                </x-slot:tab5>
                
        </x-form-wizzard>
    </div>
    @push('css')
        <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
        <script src="{{ asset('js/flatpickr.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    @endpush
</div>
