<div wire:ignore.self class="modal fade" id="adminInfoModal" tabindex="-1" aria-labelledby="adminInfoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="adminInfoModalLabel">
                    Agregar info: {{ $infoTitulo }}
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                @error('infoFile')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                <div id="adminInfoPasteZone" tabindex="0" class="border rounded-3 p-3 text-center bg-light mb-3"
                    style="border-style: dashed !important;">
                    <div class="mb-2">
                        <i class="fas fa-paste fa-2x text-info"></i>
                    </div>

                    <h6 class="mb-1">Pegar captura aquí</h6>

                    <p class="text-muted mb-0 small">
                        Copie una captura de pantalla y presione <strong>Ctrl + V</strong> dentro de este cuadro.
                    </p>

                    @if ($infoPastedImageData)
                        <div class="mt-3 d-flex align-items-center justify-content-center">
                            <div class="d-flex align-items-center gap-2 border rounded p-2 bg-white shadow-sm">
                                <img src="{{ $infoPastedImageData }}" class="rounded border"
                                    style="width:64px; height:64px; object-fit:cover;">

                                <div class="small text-start">
                                    <div class="fw-semibold">
                                        Screenshot pegado
                                    </div>

                                    <div class="text-muted">
                                        Se guardará como imagen.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">O cargar archivo desde disco</label>

                    <input type="file" id="adminInfoFileInput" class="form-control" wire:model="infoFile"
                        accept="image/*,.pdf,application/pdf">

                    <div wire:loading wire:target="infoFile" class="text-primary small mt-2">
                        Cargando archivo...
                    </div>

                    <div class="form-text">
                        Formatos permitidos: JPG, PNG, WEBP o PDF. Máximo 10 MB.
                    </div>

                    @if ($infoFile)
                        <div class="mt-2">
                            @php
                                $mimePreview = $infoFile->getMimeType();
                                $fileNamePreview = $infoFile->getClientOriginalName();
                            @endphp

                            @if (str_starts_with($mimePreview, 'image/'))
                                <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                                    <img src="{{ $infoFile->temporaryUrl() }}" class="rounded border"
                                        style="width:52px; height:52px; object-fit:cover;">

                                    <div class="small">
                                        <div class="fw-semibold">
                                            Imagen seleccionada
                                        </div>

                                        <div class="text-muted text-truncate" style="max-width:320px;">
                                            {{ $fileNamePreview }}
                                        </div>
                                    </div>
                                </div>
                            @elseif ($mimePreview === 'application/pdf')
                                <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                                    <div class="d-flex align-items-center justify-content-center rounded bg-danger text-white"
                                        style="width:52px; height:52px;">
                                        <i class="far fa-file-pdf fa-2x"></i>
                                    </div>

                                    <div class="small">
                                        <div class="fw-semibold">
                                            PDF seleccionado
                                        </div>

                                        <div class="text-muted text-truncate" style="max-width:320px;">
                                            {{ $fileNamePreview }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Comentario</label>
                    <textarea class="form-control" rows="2" wire:model.defer="infoComentario"
                        placeholder="Ejemplo: OC enviada por compras, captura de correo, comprobante de depósito, etc."></textarea>
                </div>

                <button type="button" class="btn btn-info text-white" wire:click="guardarInfoDocumento"
                    wire:loading.attr="disabled" wire:target="guardarInfoDocumento">
                    <span wire:loading.remove wire:target="guardarInfoDocumento">
                        Guardar evidencia
                    </span>

                    <span wire:loading wire:target="guardarInfoDocumento">
                        Guardando...
                    </span>
                </button>

                <hr>

                <h6 class="mb-3">Evidencias guardadas</h6>

                @if (!empty($infoDocumentos))
                    <div class="mt-3">
                        <label class="form-label">Documentos cargados</label>

                        <div class="d-flex flex-column gap-2">
                            @foreach ($infoDocumentos as $doc)
                                <div
                                    class="d-flex align-items-center justify-content-between border rounded p-2 bg-light">
                                    <a href="{{ $doc['url'] }}" target="_blank"
                                        class="d-flex align-items-center text-decoration-none text-dark flex-grow-1"
                                        title="{{ $doc['archivo_original'] }}">
                                        @if ($doc['es_imagen'])
                                            <img src="{{ $doc['url'] }}" class="rounded border me-2"
                                                style="width:35px; height:35px; object-fit:cover;">
                                        @elseif ($doc['es_pdf'])
                                            <span
                                                class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded me-2"
                                                style="width:35px; height:35px;">
                                                <i class="far fa-file-pdf"></i>
                                            </span>
                                        @else
                                            <span
                                                class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded me-2"
                                                style="width:35px; height:35px;">
                                                <i class="far fa-file"></i>
                                            </span>
                                        @endif

                                        <div class="text-truncate">
                                            <div class="small fw-bold text-truncate">
                                                {{ $doc['archivo_original'] ?? ($doc['nombre'] ?? 'Documento') }}
                                            </div>

                                            @if (!empty($doc['comentario']))
                                                <div class="small text-muted text-truncate">
                                                    {{ $doc['comentario'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger ms-2 admin-doc-delete-btn"
                                        wire:click="confirmarEliminarInfoDocumento({{ $doc['id'] }})"
                                        title="Eliminar documento">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-muted">
                        Todavía no hay evidencias guardadas para esta sección.
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .admin-doc-delete-btn {
                transition: transform 0.15s ease, color 0.15s ease, background-color 0.15s ease;
            }

            .admin-doc-delete-btn:hover {
                transform: scale(1.4);
                color: #8b0000 !important;
            }

            .admin-doc-delete-btn:hover i {
                color: #8b0000 !important;
            }
        </style>
    @endpush
    @push('livescripts')
        <script>
            window.addEventListener('abrir-modal-admin-status', function() {
                var modalEl = document.getElementById('adminStatusModal');

                if (!modalEl) {
                    console.error('No existe #adminStatusModal en esta vista.');
                    return;
                }

                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            });

            window.addEventListener('cerrar-modal-admin-status', function() {
                var modalEl = document.getElementById('adminStatusModal');

                if (!modalEl) {
                    return;
                }

                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
            });

            window.addEventListener('abrir-modal-admin-info', function() {
                var modalEl = document.getElementById('adminInfoModal');

                if (!modalEl) {
                    console.error('No existe #adminInfoModal en esta vista.');
                    return;
                }

                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();

                setTimeout(function() {
                    var zone = document.getElementById('adminInfoPasteZone');
                    if (zone) {
                        zone.focus();
                    }
                }, 300);
            });

            window.addEventListener('admin-status-actualizado', function() {
                Swal.fire({
                    title: 'Estado actualizado',
                    text: 'El estado administrativo fue actualizado correctamente.',
                    icon: 'success'
                });
            });

            window.addEventListener('admin-info-guardada', function() {
                Swal.fire({
                    title: 'Evidencia guardada',
                    text: 'La información fue guardada correctamente.',
                    icon: 'success'
                });
            });

            window.addEventListener('admin-info-eliminada', function() {
                Swal.fire({
                    title: 'Evidencia eliminada',
                    text: 'El archivo fue eliminado correctamente.',
                    icon: 'success'
                });
            });


            document.addEventListener('paste', function(event) {
                var modalEl = document.getElementById('adminInfoModal');

                if (!modalEl || !modalEl.classList.contains('show')) {
                    return;
                }

                var clipboard = event.clipboardData || event.originalEvent?.clipboardData;

                if (!clipboard || !clipboard.items) {
                    return;
                }

                for (var i = 0; i < clipboard.items.length; i++) {
                    var item = clipboard.items[i];

                    if (item.type.indexOf('image') === 0) {
                        var file = item.getAsFile();
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            @this.set('infoPastedImageData', e.target.result);
                        };

                        reader.readAsDataURL(file);

                        event.preventDefault();
                        break;
                    }
                }
            });
            window.addEventListener('confirmar-eliminar-admin-documento', function(event) {
                Swal.fire({
                    title: '¿Eliminar documento?',
                    text: 'Esta acción eliminará el archivo cargado. Si no queda respaldo ni número asociado, el estado volverá a pendiente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('eliminarInfoDocumento', event.detail.documento_id);
                    }
                });
            });
            window.addEventListener('limpiar-admin-info-file-input', function() {
                const input = document.getElementById('adminInfoFileInput');

                if (input) {
                    input.value = '';
                }
            });
        </script>
    @endpush
@endonce
