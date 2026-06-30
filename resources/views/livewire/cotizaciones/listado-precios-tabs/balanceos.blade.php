<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Precios de balanceos</strong>

        <button type="button" class="btn btn-sm btn-primary" wire:click="guardarBalanceos">
            Guardar cambios
        </button>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>HP desde</th>
                    <th>HP hasta</th>
                    <th>Polos</th>
                    <th>Precio aprox.</th>
                    <th>Activo</th>
                </tr>
            </thead>

            <tbody>
                @foreach($balanceos as $index => $row)
                    <tr>
                        <td>{{ $row['limite_inferior_hp'] }}</td>
                        <td>{{ $row['limite_superior_hp'] }}</td>
                        <td>{{ $row['polos'] }}</td>

                        <td style="width: 150px;">
                            <input type="number"
                                step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="balanceos.{{ $index }}.precio_aprox">
                        </td>

                        <td class="text-center">
                            <input type="checkbox"
                                wire:model.defer="balanceos.{{ $index }}.activo">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>