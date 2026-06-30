<div class="row">
    <div class="col-lg-5">
        <div class="card shadow-sm mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Catálogo de rodamientos</strong>

                <button type="button" class="btn btn-sm btn-primary" wire:click="guardarRodamientosCatalogo">
                    Guardar catálogo
                </button>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Serie</th>
                            <th>Ø exterior mm</th>
                            <th>Orden</th>
                            <th>Activo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rodamientosCatalogo as $index => $row)
                            <tr>
                                <td>{{ $row['codigo'] }}</td>
                                <td>{{ $row['serie'] }}</td>

                                <td style="width: 120px;">
                                    <input type="number"
                                        step="0.01"
                                        class="form-control form-control-sm text-end"
                                        wire:model.defer="rodamientosCatalogo.{{ $index }}.diametro_exterior_mm">
                                </td>

                                <td style="width: 90px;">
                                    <input type="number"
                                        step="1"
                                        class="form-control form-control-sm text-end"
                                        wire:model.defer="rodamientosCatalogo.{{ $index }}.orden">
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                        wire:model.defer="rodamientosCatalogo.{{ $index }}.activo">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Precios de rodamientos</strong>

                <button type="button" class="btn btn-sm btn-primary" wire:click="guardarRodamientosPrecios">
                    Guardar precios
                </button>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Código base</th>
                            <th>Serie</th>
                            <th>Marca</th>
                            <th>Sellos</th>
                            <th>Jaula</th>
                            <th>Juego radial</th>
                            <th>Aislamiento</th>
                            <th>Designación</th>
                            <th>Moneda</th>
                            <th>Precio</th>
                            <th>Activo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rodamientosPrecios as $index => $row)
                            <tr>
                                <td>{{ $row['codigo_base'] }}</td>
                                <td>{{ $row['serie'] }}</td>
                                <td>{{ $row['marca'] }}</td>
                                <td>{{ $row['sellos'] }}</td>
                                <td>{{ $row['jaula'] }}</td>
                                <td>{{ $row['juego_radial'] }}</td>
                                <td>{{ $row['aislamiento'] }}</td>

                                <td style="min-width: 190px;">
                                    <input type="text"
                                        class="form-control form-control-sm"
                                        wire:model.defer="rodamientosPrecios.{{ $index }}.designacion">
                                </td>

                                <td style="width: 90px;">
                                    <select class="form-control form-control-sm"
                                        wire:model.defer="rodamientosPrecios.{{ $index }}.moneda">
                                        <option value="GTQ">GTQ</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </td>

                                <td style="width: 130px;">
                                    <input type="number"
                                        step="0.01"
                                        class="form-control form-control-sm text-end"
                                        wire:model.defer="rodamientosPrecios.{{ $index }}.precio">
                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                        wire:model.defer="rodamientosPrecios.{{ $index }}.activo">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>