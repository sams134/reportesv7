<div>
    <style>
        .thumbs-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .thumbs-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 10px;
        }

        .thumb-item {
            overflow: hidden;
        }

        .thumb-img {
            width: 100%;
            height: auto;
            object-fit: cover;
            cursor: pointer;
            transition: border 0.3s;
        }

        .thumb-img.selected {
            border: 4px solid red;
            /* Cambia el borde cuando está seleccionado */
        }
    </style>
    <x-page-title>
        <x-slot:title>
         @if ($editing)
            Editar Balanceo para OS {{$this->motor->fullos}}
         @else
         Creacion de Nuevo Balanceo para OS {{$this->motor->fullos}}
         @endif
      </x-slot:title>
        Ingrese los datos para crear el informe de balanceo
       
    </x-page-title>
    <div class="row">
        <div class="col-12 ">
            <x-form-card title="Informacion en hoja escrita">
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="nombreCliente">Radio Izquierdo</label>
                        <input class="form-control" id="nombreCliente" type="text"
                            placeholder="Radio Izquierdo en pulgadas" wire:model.defer="left_radius" />
                        @error('left_radius')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="nombreCliente">Radio Derecho</label>
                        <input class="form-control" id="nombreCliente" type="text"
                            placeholder="Radio Derecho en pulgadas" wire:model.defer="right_radius" />
                        @error('right_radius')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="dimensionA">Dimension A</label>
                        <input class="form-control" id="dimensionA" type="text" placeholder="Dimension A"
                            wire:model.defer="dimensionA" />
                        @error('dimensionA')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="dimensionB">Dimension B</label>
                        <input class="form-control" id="dimensionB" type="text" placeholder="Dimension B"
                            wire:model.defer="dimensionB" />
                        @error('dimensionB')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </x-form-card>
        </div>
    </div>

    <div class="row">
        <div class="col-12 ">
            <x-form-card title="Seleccione Arte para informe de Balanceo">
                <div class="row">
                    <div class="mb-3 col-12">
                        @livewire('balanceo.create-art-modal')
                    </div>
                    <div class="col-3">
                        <x-form-card title="Arte Seleccionado">
                            <div class="thumb-item">
                                @if (!empty($selected_art) && file_exists(public_path($selected_art)))
                                    <img src="{{ asset($selected_art) }}" alt="Imagen" class="thumb-img ">
                                @else
                                    <p>No image selected or file does not exist.</p>
                                @endif
                                @error('art_id')
                                    <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                                 @enderror
                            </div>
                        </x-form-card>
                    </div>
                    <div class="col-9">
                        <x-pretty-card>
                            <div class="thumbs-container">
                                <div class="thumbs-grid">
                                    @foreach ($artes as $foto)
                                        <div class="thumb-item">
                                            <img src="{{ asset($foto->image) }}" alt="Imagen"
                                                class="thumb-img {{ $art_id == $foto->id ? 'selected' : '' }}"
                                                wire:click="selectImage({{ $foto->id }})">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </x-pretty-card>
                    </div>
                </div>
            </x-form-card>
        </div>
    </div>
    <div class="row">
        <div class="col-12 ">
            <x-form-card title="Tratar de Cargar Archivo de Balanceo">
                <div class="row">
                    <div class="mb-3 col-12">
                        <label class="form-label" for="informeBalanceoFile">Cargue Archivo de Balanceo</label>
                        <input class="form-control" id="informeBalanceoFile" type="file" accept=".sum"
                            wire:model="informeBalanceoFile" />

                        @error('informeBalanceoFile')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($informeBalanceoFile && $reading_error == 0)
                        <div class="alert alert-success" role="alert">Al parecer el archivo fue cargado adecuadamente
                        </div>
                    @endif
                    @if ($informeBalanceoFile && $reading_error == 1)
                        <div class="alert alert-danger" role="alert">Uno o varios campos no pudieron leerse
                            correctamente</div>
                    @endif
                </div>
            </x-form-card>
        </div>
    </div>

    <div class="row">
        <div class="col-12 ">
            <x-form-card title="Informacion en archivo de balanceo">
               <div class="row">
                  <div class="mb-3 col-12 col-md-6">
                     <label class="form-label" for="dateText">Fecha</label>
                     <input class="form-control" id="dateText" type="text" placeholder="Fecha"
                        wire:model.defer="dateText" />
                     @error('dateText')
                        <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3 col-12 col-md-6">
                     <label class="form-label" for="comments">Pieza a balancear</label>
                     <input class="form-control" id="comments" type="text"
                        placeholder="Pieza a balancear" wire:model.defer="comments" />
                     @error('comments')
                        <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                     @enderror
                  </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="nombreCliente">Rpm Motor</label>
                        <input class="form-control" id="nombreCliente" type="text" placeholder="Rpm Motor"
                            wire:model.defer="service_speed" />
                        @error('service_speed')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="balancing_speed">Velocidad de Balanceo</label>
                        <input class="form-control" id="balancing_speed" type="text"
                            placeholder="Velocidad de Balanceo" wire:model.defer="balancing_speed" />
                        @error('balancing_speed')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="item_weight">Peso de la Pieza</label>
                        <input class="form-control" id="item_weight" type="text" placeholder="Peso de la Pieza"
                            wire:model.defer="item_weight" />
                        @error('item_weight')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="grade">Grado de Balanceo</label>
                        <input class="form-control" id="grade" type="text" placeholder="Grado de Balanceo"
                            wire:model.defer="grade" />
                        @error('grade')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="gin_initial_left"> Begining Unbalance Left (g-in) </label>
                        <input class="form-control" id="gin_initial_left" type="text"
                            placeholder="Desbalance Inicial Izquierdo (g-in)" wire:model.defer="gin_initial_left" />
                        @error('gin_initial_left')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="gin_initial_right"> Begining Unbalance Right (g-in) </label>
                        <input class="form-control" id="gin_initial_right" type="text"
                            placeholder="Desbalance Inicial Derecho (g-in)" wire:model.defer="gin_initial_right" />
                        @error('gin_initial_right')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="gin_final_left"> Residual Unbalance Left (g) </label>
                        <input class="form-control" id="gin_final_left" type="text"
                            placeholder="Desbalance Residual Izquierdo (g)" wire:model.defer="gin_final_left" />
                        @error('gin_final_left')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label" for="gin_final_right"> Residual Unbalance Right (g) </label>
                        <input class="form-control" id="gin_final_right" type="text"
                            placeholder="Desbalance Residual Derecho (g)" wire:model.defer="gin_final_right" />
                        @error('gin_final_right')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label" for="key_drive_wide"> Ancho cu&ntilde;a lado carga (wide) </label>
                        <input class="form-control" id="key_drive_wide" type="text"
                            placeholder="Ancho cu&ntilde;a (wide)" wire:model.defer="key_drive_wide" />
                        @error('key_drive_wide')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label" for="key_drive_thick"> Espesor cu&ntilde;a lado carga (thick)
                        </label>
                        <input class="form-control" id="key_drive_thick" type="text"
                            placeholder="Espesor cu&ntilde;a (thick)" wire:model.defer="key_drive_thick" />
                        @error('key_drive_thick')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label" for="key_drive_length"> Longitud cu&ntilde;a lado carga (length)
                        </label>
                        <input class="form-control" id="key_drive_length" type="text"
                            placeholder="Longitud cu&ntilde;a (length)" wire:model.defer="key_drive_length" />
                        @error('key_drive_length')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                     
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label" for="key_rear_wide"> Ancho cu&ntilde;a lado no carga (wide) </label>
                        <input class="form-control" id="key_rear_wide" type="text"
                            placeholder="Ancho cu&ntilde;a (wide)" wire:model.defer="key_rear_wide" />
                        @error('key_rear_wide')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label" for="key_rear_thick"> Espesor cu&ntilde;a lado no carga (thick)
                        </label>
                        <input class="form-control" id="key_rear_thick" type="text"
                            placeholder="Espesor cu&ntilde;a (thick)" wire:model.defer="key_rear_thick" />
                        @error('key_rear_thick')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label" for="key_rear_length"> Longitud cu&ntilde;a lado no carga (length)
                        </label>
                        <input class="form-control" id="key_rear_length" type="text"
                            placeholder="Longitud cu&ntilde;a (length)" wire:model.defer="key_rear_length" />
                        @error('key_rear_length')
                            <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
            </x-form-card>
        </div>
    </div>
    <div class="row">
      <x-form-card title="Corridas de balanceo">
         <div class="row">
            <div class="mb-3 col-12 col-md-4">
               <label class="form-label" for="runsQuantity">Cantidad de corridas</label>
               <input class="form-range" id="customRange2" type="range" min="2" max="8" wire:model.debounce.500ms="runs"/>
               <p>{{$runs}} Corridas</p>
               <button class="btn btn-danger me-1 mb-1" type="button" wire:click="autofill">Autorellenar
               </button>
            </div>
            <div class="mb-3 col-12 col-md-4">
               <label class="form-label" for="milTolerance"> Tolerancia en mils (dejar en 0.3 si no se sabe) </label>
               </label>
               <input class="form-control" id="milTolerance" type="text"
                   placeholder="Longitud cu&ntilde;a (length)" wire:model.defer="milTolerance" />
               @error('milTolerance')
                   <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
               @enderror
           </div>
         </div>
         @for ($i = 0; $i < $runs; $i++)
      <x-form-card title="Corrida {{ $i + 1 }}">
         <div class="row" wire:key="input-row-{{ $i }}">
            <div class="mb-3 col-12 col-sm-6 col-md-3">
               <label class="form-label" for="milsLeft">Mils Izquierdo</label>
               <input class="form-control" id="milsLeft" type="text" placeholder="Mils Izquierdo" wire:model.defer="milsLeft.{{$i}}" wire:key="mi{{$i}}"/>
               @error('milsLeft')
                  <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3 col-12 col-sm-6 col-md-3">
               <label class="form-label" for="angleLeft">Angulo Izquierdo</label>
               <input class="form-control" id="angleLeft" type="text" placeholder="Angulo Izquierdo" wire:model.defer="angleLeft.{{$i}}" wire:key="ai{{$i}}"/>
               @error('angleLeft')
                  <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3 col-12 col-sm-6 col-md-3">
               <label class="form-label" for="milsRight">Mils Derecho</label>
               <input class="form-control" id="milsRight" type="text" placeholder="Mils Derecho" wire:model.defer="milsRight.{{$i}}" wire:key="md{{$i}}"/>
               @error('milsRight')
                  <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3 col-12 col-sm-6 col-md-3">
               <label class="form-label" for="angleRight">Angulo Derecho</label>
               <input class="form-control" id="angleRight" type="text" placeholder="Angulo Derecho" wire:model.defer="angleRight.{{$i}}" wire:key="ad{{$i}}"/>
               @error('angleRight')
                  <div class="alert alert-danger my-1" role="alert">{{ $message }}</div>
               @enderror
            </div>
         </div>
      </x-form-card>
         @endfor
      </x-form-card>
    </div>
    <div class="bg-light clearfix px-4 py-1">
       
      <button type="button" class="btn btn-warning float-end m-2 mr-4" wire:click="viewPdf">
          <i class="fas fa-file-pdf"></i> Guardar y Ver Pdf
      </button>
      <a type="button" class="btn btn-primary float-end m-2" href="{{route('motores.show',$motor)}}">Cancelar</a>
  </div>
</div>
@push('livescripts')
    <script></script>
@endpush
