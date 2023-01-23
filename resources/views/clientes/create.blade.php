<x-app-layout>
    <x-page-title>
        <x-slot:title>Creacion de Cliente Nuevo</x-slot:title>
        Ingrese los datos del cliente
    </x-page-title>
    <div class="row">
        <div class="col-12 ">
            <x-form-card title="Informacion de Cliente">
                <div class="mb-3">
                    <label class="form-label" for="nombreCliente">Cliente</label>
                    <input class="form-control" id="nombreCliente" type="text" placeholder="Nombre Cliente" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nombreRazonSocial">Razon Social</label>
                    <input class="form-control" id="nombreRazonSocial" type="text" placeholder="Cliente S.A." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nit">Nit</label>
                    <input class="form-control" id="nit" type="text" placeholder="Nit" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="DireccionFiscal">Direccion Fiscal</label>
                    <input class="form-control" id="DireccionFiscal" type="text" placeholder="Direccion Fiscal" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="DireccionPlanta">Direccion Planta</label>
                    <input class="form-control" id="DireccionPlanta" type="text" placeholder="Direccion Planta" />
                </div>
            </x-form-card>
        </div>

    </div>
</x-app-layout>
