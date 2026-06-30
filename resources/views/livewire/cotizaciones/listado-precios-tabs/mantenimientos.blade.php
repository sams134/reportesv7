<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Precios de mantenimientos</strong>

        <button type="button" class="btn btn-sm btn-primary" wire:click="guardarMantenimientos">
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
                    <th>Voltaje máx.</th>
                    <th>Precio aprox.</th>
                    <th>Pruebas estator</th>
                    <th>Trab. motor completo</th>
                    <th>Pruebas motor completo</th>
                    <th>Trab. reductora</th>
                    <th>Pruebas reductora</th>
                    <th>Trab. bomba</th>
                    <th>Pruebas bomba</th>
                    <th>Trab. ventilador</th>
                    <th>Pruebas ventilador</th>
                    <th>Trab. máquina</th>
                    <th>Pruebas máquina</th>
                    <th>Activo</th>
                </tr>
            </thead>

            <tbody>
                @foreach($mantenimientos as $index => $row)
                    <tr>
                        <td>{{ $row['limite_inferior_hp'] }}</td>
                        <td>{{ $row['limite_superior_hp'] }}</td>
                        <td>{{ $row['polos'] }}</td>
                        <td>{{ $row['voltaje_max'] }}</td>

                        @foreach([
                            'precio_aprox',
                            'costo_pruebas_estator',
                            'costo_trabajos_motor_completo',
                            'costo_pruebas_motor_completo',
                            'costo_trabajos_reductora',
                            'costo_pruebas_reductora',
                            'costo_trabajos_bomba',
                            'costo_pruebas_bomba',
                            'costo_trabajos_ventilador',
                            'costo_pruebas_ventilador',
                            'costo_trabajos_maquina',
                            'costo_pruebas_maquina',
                        ] as $campo)
                            <td style="min-width: 110px;">
                                <input type="number"
                                    step="0.01"
                                    class="form-control form-control-sm text-end"
                                    wire:model.defer="mantenimientos.{{ $index }}.{{ $campo }}">
                            </td>
                        @endforeach

                        <td class="text-center">
                            <input type="checkbox"
                                wire:model.defer="mantenimientos.{{ $index }}.activo">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>