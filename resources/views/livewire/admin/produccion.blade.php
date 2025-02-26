<div>
    <x-page-title>
        <x-slot:title>Produccion de {{$user->name}}</x-slot:title>
        Vea la prroducci&oacute;n que ser&aacute; acreditada en su planilla
    </x-page-title>
    <x-form-card title="Seleccion de Semana">
        <div class="row">
            <div class="col-12 col-md-4">
                <label class="form-label" for="InfoCliente">Semana</label>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" wire:model="week_selected">
                
                    <option value="0">Esta Semana</option>
                    <option value="-1">Semana Pasada</option>
                    <option value="-2">Hace 2 Semanas</option>
                    <option value="-3">Hace 3 Semanas</option>
                  </select>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3" >
                    <label class="form-label" for="InfoCliente">Fecha Inicio</label>
  
                    <input class="form-control" id="ciudad" type="text" placeholder="Fecha Inicio" 
                    value="{{ ucfirst($initial_date->locale('es')->isoFormat('dddd D [de] MMMM h:mm:ss A')) }}" />
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="mb-3">
                    <div class="mb-3" >
                        <label class="form-label" for="InfoCliente">Fecha Final</label>
                        <input class="form-control" id="ciudad" type="text"  placeholder="Fecha Fianl"
                        value="{{ ucfirst($final_date->locale('es')->isoFormat('dddd D [de] MMMM h:mm:ss A')) }}" />
                    </div>
                </div>
            </div>
        </div>
    </x-form-card>
    <x-form-card title="Produccion">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hover ">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">OS</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Potencia</th>
                        <th scope="col">Trabajo Realizado</th>
                        <th scope="col">Compartido Con:</th>
                        <th scope="col">Fecha Finalizado</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($produccion as $index => $motor)
                            <tr @if($index % 2 == 0) style="background-color: #f2f2f2;" @endif>
                                <td><a href="{{route('motores.show',$motor)}}">{{$motor->fullOS}}</a></td>
                                <td>{{$motor->cliente->cliente}}</td>
                                <td>{{$motor->potencia}}</td>
                                <td>{{$motor->tipoTrabajo?$motor->tipoTrabajo->name:""}}</td>
                                <td> 

                                    @if ($motor->asignados->count() > 1)
                                    <ul>
                                        @foreach ($motor->asignados as $asignado)
                                          
                                       <li> {{$asignado->name}} <span class="badge bg-danger">{{ $asignado->pivot->responsabilidad }}%</span></li>
                                           
                                        @endforeach
                                    </ul>
                                    @else   
                                        <span class="badge bg-secondary">Nadie</span>
                                    @endif
                                </td>
                                <td>{{ucfirst(\Carbon\Carbon::parse($motor->end)->locale('es')->isoFormat('dddd D [de] MMMM')) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-form-card>
    <x-form-card title="Adicionales">
        @if ($week_selected == 0)
        <div class="row">
            <label class="form-label
            ">Agregue cualquier trabajo reportable. Este trabajo sera agregado el dia {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd D [de] MMMM') }}</label>
            <div class="col-12 d-flex align-middle">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-plus"></i></span>
                    <input class="form-control" type="text" placeholder="Trabajo realizado" wire:model="work"/>
                </div>
                <button class="btn btn-success btn-sm mx-3 mb-1 px-2 py-0" type="button" wire:click="addWork" style="height: auto; align-self: stretch;">Agregar
                </button>
            </div>
        </div>
            
        @endif
        
        @if ($otherWorks->count() > 0)
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hover ">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col" style="width:30%">Fecha</th>
                        <th scope="col" style="width:60%">Trabajo Realizado</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($otherWorks as $index => $work)
                            <tr @if($index % 2 == 0) style="background-color: #f2f2f2;" @endif>
                                <td>{{ucfirst(\Carbon\Carbon::parse($work->created_at)->locale('es')->isoFormat('dddd D [de] MMMM')) }}</td>
                                <td>{{$work->descripcion}}</td>
                            <td>  
                                @if ($week_selected == 0)
                                <button class="btn btn-danger btn-sm mx-3 mb-1 px-2 py-0" type="button" onclick="deleteWork({{ $work->id }})" style="height: auto; align-self: stretch;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                @endif
                            </td>
                            </button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        @endif
    </x-form-card>
    <x-form-card title="Horas Extras">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hover ">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Cant Horas</th>
                        <th scope="col">OS</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Autorizadas Por:</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach ($horas_extras as $index => $hora)
                         <tr @if($index % 2 == 0) style="background-color: #f2f2f2;" @endif>
                            <td>{{ucfirst(\Carbon\Carbon::parse($hora->init)->locale('es')->isoFormat('dddd D [de] MMMM')) }}</td>
                            <td>{{ number_format($hora->hours, 2) }} horas</td>
                            <td><a href="{{route('motores.show',$motor)}}"> <span class="fw-bold">{{$hora->motor->fullOS}}</span>
                                <br> {{$hora->motor->potencia}}</a>
                            </td>
                            <td>{{$hora->motor->cliente->cliente}}</td>
                            <td> @if($hora->autorizado_por == $hora->user->id)
                                <span>Sistema</span>
                            @else
                                <span >{{ $hora->autorizadoPor->name }}</span>
                            @endif</td>
                         </tr>
                     @endforeach
                     <tr>
                        <td colspan="5" class="text-end">
                            <span class="fw-bold">Total Horas: {{ number_format($horas_extras->sum('hours'), 2) }} horas, se acreditan: {{ ceil($horas_extras->sum('hours')) }} horas</span>
                        </td>
                     </tr>
                     
                    </tbody>
                  </table>
            </div>
        </div>
    </x-form-card>
    
    {{-- Botones de imprimir pdf --}}
    
        <div class="row card p-3 m-1">
            <div class="col-12">
                <div class="d-grid gap
                -2 d-md-flex justify-content-md-end">
                    <a class="btn btn-danger" wire:click="printPDF" href="{{route('admin.produccionPDF')}}">
                        <i class="fas fa-file-pdf"></i> Imprimir Produccion
                    </a>
                </div>
            </div>
        </div>
   
</div>
<script>
    function deleteWork(key)
{
    console.log("hola");
    Swal.fire({
        title: 'Seguro que desea eliminar este trabajo? Ya no aparecera en tu planilla',
        text: "Este cambio no puede ser revertido",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Borrarlo',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
           Livewire.emit('deleteWork',key);
        }
    })
}
</script>
