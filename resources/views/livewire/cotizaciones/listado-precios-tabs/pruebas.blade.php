<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Precios de pruebas</strong>

        <button type="button" class="btn btn-sm btn-primary" wire:click="guardarPruebas">
            Guardar cambios
        </button>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Cliente</th>
                    <th>Tipo prueba</th>
                    <th>Ubicación</th>
                    <th>Tensión</th>
                    <th>HP</th>
                    <th>Voltaje</th>
                    <th>Cantidad equipos</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Moneda</th>
                    <th>Precio unitario</th>
                    <th>Precio total</th>
                    <th>Activo</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pruebas as $index => $row)
                    <tr>
                        <td>{{ $row['cliente_nombre'] ?? 'General' }}</td>
                        <td>{{ $row['prueba_tipo'] }}</td>
                        <td>{{ $row['ubicacion'] }}</td>
                        <td>{{ $row['tension_tipo'] }}</td>
                        <td>{{ $row['hp'] }}</td>
                        <td>{{ $row['voltaje'] }}</td>
                        <td>{{ $row['cantidad_equipos'] }}</td>

                        <td style="min-width: 180px;">
                            <input type="text"
                                class="form-control form-control-sm"
                                wire:model.defer="pruebas.{{ $index }}.nombre">
                        </td>

                        <td style="min-width: 280px;">
                            <textarea class="form-control form-control-sm"
                                rows="2"
                                wire:model.defer="pruebas.{{ $index }}.descripcion"></textarea>
                        </td>

                        <td style="width: 90px;">
                            <select class="form-control form-control-sm"
                                wire:model.defer="pruebas.{{ $index }}.moneda">
                                <option value="GTQ">GTQ</option>
                                <option value="USD">USD</option>
                            </select>
                        </td>

                        <td style="width: 130px;">
                            <input type="number"
                                step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="pruebas.{{ $index }}.precio_unitario">
                        </td>

                        <td style="width: 130px;">
                            <input type="number"
                                step="0.01"
                                class="form-control form-control-sm text-end"
                                wire:model.defer="pruebas.{{ $index }}.precio_total">
                        </td>

                        <td class="text-center">
                            <input type="checkbox"
                                wire:model.defer="pruebas.{{ $index }}.activo">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>