<div wire:ignore.self class="modal fade" id="adminStatusModal" tabindex="-1" aria-labelledby="adminStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="adminStatusModalLabel">
                    Actualizar estado administrativo
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                @error('adminStatusId')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="row g-3">
                    {{-- Cotización externa --}}
                    <div class="col-md-4">
                        <label class="form-label">Cotización</label>

                        <div>
                            @if (($adminDocumentosResumen['cotizacion_externa'] ?? []) || ($cotizacion_estado ?? null) === 'cotizado')
                                <span class="badge bg-success">Cotizado</span>
                            @else
                                <span class="badge bg-danger">Pendiente</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Cotización externa o respaldo</label>

                        <button type="button" class="btn btn-outline-primary w-100"
                            wire:click="abrirModalInfo('cotizacion_externa')">
                            <i class="fas fa-paperclip me-1"></i>
                            Agregar cotización externa
                        </button>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['cotizacion_externa'] ?? [],
                        ])
                    </div>
                    {{-- Requerimiento --}}
                    <div class="col-md-4">
                        <label class="form-label">Requerimiento</label>
                        <select class="form-select" wire:model.defer="requerimiento_estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="recibido">Recibido</option>
                            <option value="no_aplica">No aplica</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Número de requerimiento</label>

                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.defer="requerimiento_numero">

                            <button type="button" class="btn btn-outline-primary"
                                wire:click="abrirModalInfo('requerimiento')">
                                <i class="fas fa-paperclip me-1"></i>
                                Agregar info
                            </button>
                        </div>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['requerimiento'] ?? [],
                        ])
                    </div>

                    {{-- OC --}}
                    <div class="col-md-4">
                        <label class="form-label">OC</label>
                        <select class="form-select" wire:model.defer="oc_estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="recibida">Recibida</option>
                            <option value="no_aplica">No aplica</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Número de OC</label>

                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.defer="oc_numero">

                            <button type="button" class="btn btn-outline-primary" wire:click="abrirModalInfo('oc')">
                                <i class="fas fa-paperclip me-1"></i>
                                Agregar info
                            </button>
                        </div>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['oc'] ?? [],
                        ])
                    </div>

                    {{-- Autorización --}}
                    <div class="col-md-4">
                        <label class="form-label">Autorización</label>
                        <select class="form-select" wire:model.defer="autorizacion_estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="verbal">Verbal</option>
                            <option value="previa">Previa</option>
                            <option value="confianza">Confianza</option>
                            <option value="recibida">Recibida</option>
                            <option value="no_aplica">No aplica</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Comentario de autorización</label>
                        <input type="text" class="form-control" wire:model.defer="autorizacion_comentario"
                            placeholder="Ejemplo: Ing. Pérez autorizó al Ing. Samuel Mayorga iniciar el trabajo.">
                    </div>

                    {{-- Anticipo --}}
                    <div class="col-md-4">
                        <label class="form-label">Anticipo</label>
                        <select class="form-select" wire:model.defer="anticipo_estado">
                            <option value="no_aplica">No aplica</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="solicitado">Solicitado</option>
                            <option value="recibido">Recibido</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Monto anticipo</label>

                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" wire:model.defer="anticipo_monto">

                            <button type="button" class="btn btn-outline-primary"
                                wire:click="abrirModalInfo('anticipo')">
                                <i class="fas fa-paperclip me-1"></i>
                                Agregar info
                            </button>
                        </div>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['anticipo'] ?? [],
                        ])
                    </div>

                    {{-- Aceptación --}}
                    <div class="col-md-4">
                        <label class="form-label">Aceptación</label>
                        <select class="form-select" wire:model.defer="aceptacion_estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="recibida">Recibida</option>
                            <option value="no_aplica">No aplica</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Número de aceptación</label>

                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.defer="aceptacion_numero">

                            <button type="button" class="btn btn-outline-primary"
                                wire:click="abrirModalInfo('aceptacion')">
                                <i class="fas fa-paperclip me-1"></i>
                                Agregar info
                            </button>
                        </div>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['aceptacion'] ?? [],
                        ])
                    </div>

                    {{-- Factura --}}
                    <div class="col-md-4">
                        <label class="form-label">Factura</label>
                        <select class="form-select" wire:model.defer="factura_estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="emitida">Emitida</option>
                            <option value="enviada">Enviada</option>
                            <option value="no_aplica">No aplica</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Número de factura</label>

                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.defer="factura_numero">

                            <button type="button" class="btn btn-outline-primary"
                                wire:click="abrirModalInfo('factura')">
                                <i class="fas fa-paperclip me-1"></i>
                                Agregar info
                            </button>
                        </div>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['factura'] ?? [],
                        ])
                    </div>

                    {{-- Contraseña de pago --}}
                    <div class="col-md-4">
                        <label class="form-label">Contraseña de pago</label>
                        <select class="form-select" wire:model.defer="contrasena_pago_estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="recibida">Recibida</option>
                            <option value="no_aplica">No aplica</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Número de contraseña</label>

                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.defer="contrasena_pago_numero">

                            <button type="button" class="btn btn-outline-primary"
                                wire:click="abrirModalInfo('contrasena_pago')">
                                <i class="fas fa-paperclip me-1"></i>
                                Agregar info
                            </button>
                        </div>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['contrasena_pago'] ?? [],
                        ])
                    </div>

                    {{-- Pago --}}
                    <div class="col-md-4">
                        <label class="form-label">Pago</label>
                        <select class="form-select" wire:model.defer="pago_estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                            <option value="no_aplica">No aplica</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Comprobante de pago</label>

                        <button type="button" class="btn btn-outline-primary w-100"
                            wire:click="abrirModalInfo('pago')">
                            <i class="fas fa-paperclip me-1"></i>
                            Agregar info de pago
                        </button>

                        @include('livewire.administracion.partials.admin-docs-mini', [
                            'docs' => $adminDocumentosResumen['pago'] ?? [],
                        ])
                    </div>

                    {{-- Comentarios --}}
                    <div class="col-md-12">
                        <label class="form-label">Comentarios administrativos</label>
                        <textarea class="form-control" rows="3" wire:model.defer="comentarios"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="button" class="btn btn-primary" wire:click="guardarAdminStatus"
                    wire:loading.attr="disabled" wire:target="guardarAdminStatus">
                    <span wire:loading.remove wire:target="guardarAdminStatus">
                        Guardar estado
                    </span>

                    <span wire:loading wire:target="guardarAdminStatus">
                        Guardando...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
