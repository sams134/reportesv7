<div>
    <style>
        .minitabla {
            table-layout: fixed;
            /* Asegura un diseño de tabla de tamaño fijo */
            width: 100%;
            /* Opcional, ajusta el ancho de la tabla */
        }

        .minitabla td,
        .minitabla th {
            height: 10px !important;
            /* Forzamos la altura de las celdas */
            vertical-align: middle;
            /* Alineamos verticalmente el contenido */
        }

        .minitabla tr {
            height: 10px !important;
            /* Forzamos la altura de las filas */
        }
    </style>



    <a class="btn btn-outline-primary me-1 mb-1" type="button" data-bs-toggle="modal" data-bs-target="#newMetalizado-modal"
        href="#">
        <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Nuevo Metalizado
    </a>


    <div wire:ignore.self class="modal fade" id="newMetalizado-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Crear Nuevo Metalizado</h4>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="row">

                            <div class="col-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="fullos" class="form-label">Busque OS</label>
                                    <input type="text" class="form-control" id="fullos" wire:model="search">
                                    @error('fullos')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="card shadow-none">
                                        <div class="card-body p-0 pb-3">

                                            <div class="table-responsive scrollbar">
                                                <span wire:loading> Loading</span>

                                                <table class="table mb-0 minitabla table-hover" style="font-size: 12px;"
                                                    wire:loading.class="opacity-50">
                                                    <thead class="text-black bg-200">
                                                        <tr>
                                                            <th class="align-middle white-space-nowrap">
                                                                <div class="form-check mb-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' />
                                                                </div>
                                                            </th>
                                                            <th class="align-middle">OS</th>
                                                            <th class="align-middle">Cliente</th>
                                                            <th class="align-middle">Potencia</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="bulk-select-body">
                                                        @foreach ($motors as $motor)
                                                            <tr wire:click="selectMotor({{ $motor->id_motor }})"
                                                                style="cursor: pointer;"
                                                                @if ($motorSelected == $motor->id_motor) class="table-primary" @endif>
                                                                <td class="align-middle white-space-nowrap">
                                                                    <div class="form-check mb-0">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="checkbox-{{ $motor->id_motor }}"
                                                                            data-bulk-select-row="data-bulk-select-row"
                                                                            @if ($motorSelected == $motor->id_motor) checked @endif />
                                                                    </div>
                                                                </td>
                                                                <td class="align-middle" width="25%">
                                                                    {{ $motor->fullos }}</td>
                                                                <td class="align-middle" width="40%">
                                                                    {{ $motor->cliente->cliente }}</td>
                                                                <td class="align-middle">{{ $motor->potencia }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="cliente_id" class="form-label">Cliente</label>
                                    <select class="form-select" id="cliente_id" wire:model="cliente_id">
                                        <option value="">Seleccione un cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id_cliente }}">
                                                {{ $cliente->cliente }}</option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="card mb-3">
                                    <div class="row p-2">
                                        <span>Ingrese nueva OS de Metalizado</span>
                                        <div class="col-5">
                                            <div class="input-group mb-2"><span class="input-group-text"
                                                    id="basic-addon1">MET-</span>
                                                <input class="form-control" type="text" wire:model="year" />
                                                @error('year')
                                                    <div class="alert alert-danger my-1 py-1" role="alert">
                                                        {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>-
                                        <div class="col-6">
                                            <div class="input-group mb-2"><span class="input-group-text"
                                                    id="basic-addon1">OS</span>
                                                <input class="form-control" type="text" wire:model="os">
                                                @error('os')
                                                    <div class="alert alert-danger my-1 py-1" role="alert">
                                                        {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-2">
                                        <div class="mb-1">
                                            <label class="form-label" for="InfoCliente">Diametro</label>
                                            <input class="form-control" id="diametro" type="number" step="0.001"
                                                value="" placeholder="Diametro parte a metalizar"
                                                wire:model.defer="diametro" />
                                            @error('diametro')
                                                <div class="alert alert-danger my-1 py-1" role="alert">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="InfoCliente">Largo</label>
                                            <input class="form-control" id="diametro" type="number" step="0.001"
                                                value="" placeholder="Diametro parte a metalizar"
                                                wire:model.defer="largo" />
                                            @error('largo')
                                                <div class="alert alert-danger my-1 py-1" role="alert">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="OptionProfundidad">Profundidad</label>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="radio" id="profundidad1"
                                                        name="profundidad" value="1"
                                                        wire:model.defer="profundidad">
                                                    <label class="form-check-label"
                                                        for="profundidad1">Profundo</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="profundidad2"
                                                        name="profundidad" value="2"
                                                        wire:model.defer="profundidad">
                                                    <label class="form-check-label" for="profundidad2">Normal</label>
                                                </div>
                                            </div>
                                            @error('profundidad')
                                                <div class="alert alert-danger my-1 py-1" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-1">
                                            <p class="form-label" for="OptionProfundidad">Cargue una Imagen</p>
                                            <div class="">
                                                <!-- Spinner que se muestra mientras se carga la imagen -->
                                                <div wire:loading wire:target="photo">
                                                    <div class="spinner-border" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                                <!-- Imagen que se muestra cuando ya se ha cargado (se oculta mientras se carga) -->
                                                <img id="cameraBtnFoto" class="rounded-soft"
                                                    src="{{ $photo ? $photo->temporaryUrl() : asset('img/default-avatar.png') }}"
                                                    style="cursor: pointer; transition: border-color 0.3s; max-height: 200px; width: auto;"
                                                    alt="No hay foto"
                                                    onmouseover="this.style.border='2px solid #0d6efd';"
                                                    onmouseout="this.style.border='none';" wire:loading.remove
                                                    wire:target="photo" />
                                            </div>
                                            <input type="file" id="imagenBtn" wire:model="photo"
                                                style="display: none;">
                                            @error('photo')
                                                <div class="alert alert-danger my-1 py-1" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary close-modal" wire:click.prevent="store()" type="button">Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('livescripts')
    <script>
        Livewire.on('closeNewMetalizado', function() {

            const contactModal = bootstrap.Modal.getInstance(document.getElementById('newMetalizado-modal'));
            contactModal.hide();
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Metalizado creado con éxito',
                showConfirmButton: false,
                timer: 1500
            })
        })
        const cameraBtnFoto = document.querySelector('#cameraBtnFoto');
        if (cameraBtnFoto)
            cameraBtnFoto.addEventListener('click', function() {
                document.querySelector("#imagenBtn").click();
            });
    </script>
@endpush
