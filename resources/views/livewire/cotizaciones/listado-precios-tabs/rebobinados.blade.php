<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Precios de rebobinados</strong>

        <button type="button" class="btn btn-sm btn-primary" wire:click="guardarRebobinados">
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
                    <th>Lbs alambre</th>
                    <th>Inverter</th>
                    <th>Precio aprox.</th>
                    <th>Pruebas estator</th>
                    <th>Trab. motor completo</th>
                    <th>Pruebas motor completo</th>
                    <th>Activo</th>
                </tr>
            </thead>

            <tbody>
                @foreach($rebobinados as $index => $row)
                    <tr>
                        <td>{{ $row['limite_inferior_hp'] }}</td>
                        <td>{{ $row['limite_superior_hp'] }}</td>
                        <td>{{ $row['polos'] }}</td>
                        <td>{{ $row['libras_alambre'] }}</td>
                        <td>{{ !empty($row['inverter_duty']) ? 'Sí' : 'No' }}</td>

                        <td>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="rebobinados.{{ $index }}.precio_aprox">
                        </td>

                        <td>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="rebobinados.{{ $index }}.costo_pruebas_estator">
                        </td>

                        <td>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="rebobinados.{{ $index }}.costo_trabajos_motor_completo">
                        </td>

                        <td>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="rebobinados.{{ $index }}.costo_pruebas_motor_completo">
                        </td>

                        <td class="text-center">
                            <input type="checkbox"
                                wire:model.defer="rebobinados.{{ $index }}.activo">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
    window.addEventListener('swal-success', event => {
        Swal.fire({
            icon: 'success',
            title: 'Guardado',
            text: event.detail.message,
            timer: 1800,
            showConfirmButton: false
        });
    });
</script>
</div>