<div wire:ignore.self class="modal fade" id="adminInfoModal" tabindex="-1" aria-labelledby="adminInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="adminInfoModalLabel">
                    Agregar info: {{ $infoTitulo }}
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                @error('infoFile')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                <div
                    id="adminInfoPasteZone"
                    tabindex="0"
                    class="border rounded-3 p-3 text-center bg-light mb-3"
                    style="border-style: dashed !important;"
                >
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
                                <img
                                    src="{{ $infoPastedImageData }}"
                                    class="rounded border"
                                    style="width:64px; height:64px; object-fit:cover;"
                                >

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

                    <input
                        type="file"
                        class="form-control"
                        wire:model="infoFile"
                        accept="image/*,.pdf,application/pdf"
                    >

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
                                    <img
                                        src="{{ $infoFile->temporaryUrl() }}"
                                        class="rounded border"
                                        style="width:52px; height:52px; object-fit:cover;"
                                    >

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
                    <textarea
                        class="form-control"
                        rows="2"
                        wire:model.defer="infoComentario"
                        placeholder="Ejemplo: OC enviada por compras, captura de correo, comprobante de depósito, etc."
                    ></textarea>
                </div>

                <button
                    type="button"
                    class="btn btn-info text-white"
                    wire:click="guardarInfoDocumento"
                    wire:loading.attr="disabled"
                    wire:target="guardarInfoDocumento"
                >
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
                    <div class="list-group">
                        @foreach ($infoDocumentos as $doc)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between gap-2">
                                    <div>
                                        <div class="fw-bold">
                                            @if ($doc['es_pdf'])
                                                <i class="far fa-file-pdf text-danger me-1"></i>
                                            @else
                                                <i class="far fa-image text-primary me-1"></i>
                                            @endif

                                            {{ $doc['archivo_original'] }}
                                        </div>

                                        <div class="small text-muted">
                                            Subido por {{ $doc['uploaded_by'] ?? 'N/A' }}
                                            · {{ $doc['created_at'] }}
                                        </div>

                                        @if ($doc['comentario'])
                                            <div class="small mt-1">
                                                {{ $doc['comentario'] }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-end text-nowrap">
                                        <a href="{{ $doc['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            Ver
                                        </a>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            wire:click="eliminarInfoDocumento({{ $doc['id'] }})"
                                        >
                                            Eliminar
                                        </button>
                                    </div>
                                </div>

                                @if ($doc['es_imagen'])
                                    <div class="mt-3">
                                        <img
                                            src="{{ $doc['url'] }}"
                                            class="img-fluid rounded border"
                                            style="max-height:180px;"
                                        >
                                    </div>
                                @endif
                            </div>
                        @endforeach
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
    @push('livescripts')
        <script>
            window.addEventListener('abrir-modal-admin-status', function () {
                var modalEl = document.getElementById('adminStatusModal');

                if (!modalEl) {
                    console.error('No existe #adminStatusModal en esta vista.');
                    return;
                }

                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            });

            window.addEventListener('cerrar-modal-admin-status', function () {
                var modalEl = document.getElementById('adminStatusModal');

                if (!modalEl) {
                    return;
                }

                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
            });

            window.addEventListener('abrir-modal-admin-info', function () {
                var modalEl = document.getElementById('adminInfoModal');

                if (!modalEl) {
                    console.error('No existe #adminInfoModal en esta vista.');
                    return;
                }

                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();

                setTimeout(function () {
                    var zone = document.getElementById('adminInfoPasteZone');
                    if (zone) {
                        zone.focus();
                    }
                }, 300);
            });

            window.addEventListener('admin-status-actualizado', function () {
                Swal.fire({
                    title: 'Estado actualizado',
                    text: 'El estado administrativo fue actualizado correctamente.',
                    icon: 'success'
                });
            });

            window.addEventListener('admin-info-guardada', function () {
                Swal.fire({
                    title: 'Evidencia guardada',
                    text: 'La información fue guardada correctamente.',
                    icon: 'success'
                });
            });

            window.addEventListener('admin-info-eliminada', function () {
                Swal.fire({
                    title: 'Evidencia eliminada',
                    text: 'El archivo fue eliminado correctamente.',
                    icon: 'success'
                });
            });

            window.addEventListener('swal-error', function (event) {
                Swal.fire({
                    title: event.detail.title || 'Error',
                    text: event.detail.text || 'No se pudo completar la acción.',
                    icon: 'error'
                });
            });

            document.addEventListener('paste', function (event) {
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

                        reader.onload = function (e) {
                            @this.set('infoPastedImageData', e.target.result);
                        };

                        reader.readAsDataURL(file);

                        event.preventDefault();
                        break;
                    }
                }
            });
        </script>
    @endpush
@endonce