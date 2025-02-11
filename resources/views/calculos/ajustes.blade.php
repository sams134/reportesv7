<x-app-layout>
    <x-pretty-card>
        <h3>Calculo de Ajustes para ejes y alojamientos</h3>
       Calcule sus ajustes
    </x-pretty-card>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> Ingrese numero de Rodamiento</h5>
                <input type="text" class="form-control" placeholder="Numero de Rodamiento" wire:model="des">
            </div>
        </div>
        <div class="card">
            <div class="card-body col-12 col-md-6">
                <h5 class="card-title"> Datos del Rodamiento</h5>
                <div class="table-responsive scrollbar">
                    <table class="table table-striped overflow-hidden">
                      <thead>
                        <tr class="btn-reveal-trigger">
                          <th scope="col">Designacion</th>
                          <th scope="col">Diametro Interno</th>
                          <th scope="col">Diametro Externo</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr >
                          
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
            </div>
    </div>


</x-app-layout>