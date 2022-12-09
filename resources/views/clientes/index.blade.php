<x-app-layout>
    <x-page-title>
        <x-slot:title>Registro de clientes</x-slot:title>
        Vea todos los clientes en el sistema
    </x-page-title>
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background-image:url(/img/icons/spot-illustrations/corner-2.png);">
        </div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <button class="btn btn-primary me-1 mb-1" type="button">Agregar Cliente
                    </button>
                    <div class="input-group my-3"><span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-search"></i>
                    </span>
                        <input class="form-control" type="text" placeholder="Buscar Cliente" aria-describedby="basic-addon1" />
                        <button class="btn btn-primary me-1 mb-1" type="button">Agregar Cliente
                        </button>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background-image:url(/img/icons/spot-illustrations/corner-3.png);">
        </div>
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive scrollbar">
                        <table class="table table-hover table-striped overflow-hidden">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Cliente</th>
                              <th scope="col">Operaciones</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach ($clientes as $cont=>$cliente)
                              <tr class="align-middle">
                                <td class="text-nowrap" style="width:50px">
                                  {{$cont+1}}
                                </td>
                                <td class="text-nowrap" style="width:100%">
                                    <a href="{{route('clientes.show',$cliente)}}">
                                        {{$cliente->cliente}}
                                    </a>
                                    
                                </td>
                                <td class="text-nowrap">
                                    <button class="btn btn-falcon-primary rounded-pill me-1 mb-1" type="button">
                                        <span class="far fa-list-alt me-1" data-fa-transform="shrink-3"></span> Ver Motores
                                      </button>
                                      <button class="btn btn-falcon-success rounded-pill me-1 mb-1" type="button">
                                        <span class="far fa-list-alt me-1" data-fa-transform="shrink-3"></span> Agregar Motor
                                      </button>


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