<div>
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
                <div class="col-lg-12">
                    <a class="btn btn-danger me-1 mb-3" type="button" href="{{route('clientes.create')}}">Agregar Cliente
                    </a>
                    <div class="input-group mb-3">
                        
                        <input class="form-control" type="text" placeholder="Buscar Cliente" aria-label="BuscarCliente"
                            aria-describedby="basic-addon1" wire:model="search"/>
                            
                            <button class="btn btn-primary " type="button">
                                <i class="fa fa-search"></i>
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
                                    <th scope="col">Herramientas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $cont => $cliente)
                                    <tr class="align-middle">
                                        <td class="text-nowrap" style="width:50px">
                                            {{ $cont + 1 }}
                                        </td>
                                        <td class="text-nowrap" style="width:100%">
                                            <a href="{{ route('clientes.show', $cliente) }}">
                                                {{ $cliente->cliente }}
                                            </a>

                                        </td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-falcon-primary rounded-pill me-1 mb-1"
                                                type="button">
                                                <span class="far fa-list-alt me-1" data-fa-transform="shrink-3"></span>
                                                Ver Motores ({{$cliente->motors_count}})
                                            
                                            </button>
                                            <button class="btn btn-falcon-success rounded-pill me-1 mb-1"
                                                type="button">
                                                <span class="far fa-list-alt me-1" data-fa-transform="shrink-3"></span>
                                                Agregar Motor
                                            </button>
                                        </td>
                                        <td>
                                            <a class="btn btn-falcon-primary me-1 mb-1" type="button" href="{{route('clientes.edit',$cliente)}}">
                                                <i class="fas fa-edit"></i>
                                            </a>
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
</div>
