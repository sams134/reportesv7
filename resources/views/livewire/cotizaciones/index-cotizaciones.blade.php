<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <x-pretty-card>
        <h2>Listado General de Cotizaciones
        </h2>
        Revisa todos las cotizaciones creadas en el sistema
    </x-pretty-card>
     <x-pretty-card>
        <div class="d-flex">
            <a class="btn btn-outline-primary me-1 mb-1" type="button" href="{{ route('admin.cotizaciones.create') }}">
                <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Nueva Cotización
            </a>
        </div>
     </x-pretty-card>


       <div class="card-body p-0">
                <span wire:loading> Loading</span>
                {{-- <div class="px-2"> {{ $motores->withQueryString()->links() }}</div> --}}
                <div class="table-responsive scrollbar">

                    <table class="table table-hover table-striped overflow-hidden fs--1"
       style="font-size: 0.5rem; "
       wire:loading.remove>

                        <thead class="bg-300 text-dark">
                            <tr class="text-800">
                                <th style="width:5%;border:1px solid #000"><input type="checkbox" name="" id="" > </th>
                                <th style="width:1%;"></th>
                                <th class="sort" style="width:20%;cursor: pointer;"> Fecha </th>
                                <th class="sort" style="width:40%;cursor: pointer;"> Cliente </th>
                                <th class="sort" style="width:20%;cursor: pointer;"> Total </th>
                            </tr>
                        </thead>
                    </table>
                </div>
       </div>

</div>
