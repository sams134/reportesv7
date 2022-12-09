<x-app-layout>
    <x-page-title>
        <x-slot:title>{{$cliente->cliente}}</x-slot:title>
        Vea la informacion del cliente.
    </x-page-title>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="bg-holder d-none d-lg-block bg-card"
                    style="background-image:url(/img/icons/spot-illustrations/corner-2.png);">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <div class="row">
                        <h3>DATOS DEL CLIENTE</h3>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">Cliente
                                <span >{{$cliente->cliente}}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Razon Social<span >
                                {{$cliente->info_cliente->razon_social}}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Nit<span >{{$cliente->info_cliente->nit}}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Direccion Fiscal<span >{{$cliente->info_cliente->direccion_fiscal}}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Direccion Planta<span >{{$cliente->info_cliente->direccion_planta}}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Ubicacion<span >{{$cliente->ciudad}},{{$cliente->pais}}</span></li>
                          </ul>
                    </div>
                </div>
            </div>
            <x-pretty-card>
                <h3>Informacion del Cliente</h3>
                @if ($cliente->info_cliente->comentarios != '')
                    {!! $cliente->info_cliente->comentarios!!}
                @else
                   No hay informacion del cliente
                @endif
               
            </x-pretty-card>
            <div class="card mb-3">
                <div class="card-body">
                    <button class="btn btn-outline-primary me-1 mb-1" type="button">Agregar Equipo
                    </button>
                    <button class="btn btn-outline-info me-1 mb-1" type="button">Editar Cliente
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-soft-primary mb-3">
                <div class="card-body">     
                    <div class="row">
                        <div class="col-10">
                            <h2 class="text-primary fw-bold">{{$cliente->motors_count}}</h2>
                            <h4 class="text-primary">
                                Equipos Ingresados a reparacion
                            </h4>
                        </div>
                        <div class="col-2">
                            <i class="far fa-folder text-facebook " style="font-size:80px"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card bg-soft-primary mb-3">
                <div class="card-body">     
                    <div class="row">
                        <div class="col-10">
                            <h2 class="text-primary fw-bold">{{$cliente->motors_count}}</h2>
                            <h4 class="text-primary">
                                Equipos en proceso
                            </h4>
                        </div>
                        <div class="col-2">
                            <i class="fas fa-wrench text-facebook " style="font-size:80px"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <canvas id="myChart" width="400" height="300"></canvas>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h3>Contactos</h3>
                    <div class="table-responsive scrollbar">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th scope="col">Nombre</th>
                              <th scope="col">Puesto</th>
                              <th scope="col">Telefono</th>
                              <th scope="col">Email</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($cliente->contactos as $contacto)
                                <tr class="hover-actions-trigger">
                                    <td class="align-middle text-nowrap">
                                    {{$contacto->contacto}}
                                    </td>
                                    <td class="align-middle text-nowrap">{{$contacto->puesto}}</td>
                                    <td class="w-auto">
                                    {{$contacto->telefono}}
                                    </td>
                                    <td class="align-middle text-nowrap">{{$contacto->email}}</td>
                                </tr>
                              @endforeach
                            
                            
                          </tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h3>Equipos Ingresados</h3>
                    <div class="table-responsive scrollbar">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Os</th>
                              <th scope="col">Potencia</th>
                              <th scope="col">Rpm</th>
                              <th scope="col">Fecha Ingreso</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($cliente->motors as $cont=>$motor)
                                <tr class="hover-actions-trigger">
                                    <td class="align-middle text-nowrap" style="width: 80px">
                                    {{$cont+1}}
                                    </td>
                                    <td class="align-middle text-nowrap">{{$motor->year}}-{{$motor->os}}</td>
                                    <td class="w-auto">{{$motor->potencia}}</td>
                                    <td class="align-middle text-nowrap">{{$motor->rpm}}</td>
                                    <td class="align-middle text-nowrap">
                                        {{ Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}
                             
                                    </td>

                                </tr>
                              @endforeach
                            
                            
                          </tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
    </div>

    

</x-app-layout>