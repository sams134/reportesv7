<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Precios de encamisados</strong>

        <button type="button" class="btn btn-sm btn-primary" wire:click="guardarEncamisados">
            Guardar cambios
        </button>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tamaño mínimo</th>
                    <th>Tamaño máximo</th>
                    <th>Precio</th>
                    <th>Activo</th>
                </tr>
            </thead>

            <tbody>
                @foreach($encamisados as $index => $row)
                    <tr>
                        <td>{{ $row['tamanio_minimo'] }}</td>
                        <td>{{ $row['tamanio_maximo'] }}</td>

                        <td style="width: 150px;">
                            <input type="number"
                                step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="encamisados.{{ $index }}.precio">
                        </td>

                        <td class="text-center">
                            <input type="checkbox"
                                wire:model.defer="encamisados.{{ $index }}.activo">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>