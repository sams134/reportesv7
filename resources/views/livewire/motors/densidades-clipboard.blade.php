<div>
    <style>
        .clipboard-box {
            border: 2px dashed #6c757d;
            padding: 30px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            background-color: #f8f9fa;
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .clipboard-box:hover {
            background-color: #e2e6ea;
            border-color: #495057;
        }

        .preview-wrapper {
            width: 100%;
            max-height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .img-preview {
            max-width: 100%;
            max-height: 100%;
            height: auto;
            width: auto;
            object-fit: contain;
            border-radius: 6px;
        }
    </style>
    {{-- Stop trying to control. --}}
    <div class="card document-card" id="addCapture"
        style="width: 200px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; transition: transform 0.3s;">
        <a>
            <img src="{{ asset('img/pdfadd.png') }}" alt="Agregar PDF" title="Agregar PDF"
                style="width: 50%; display: block; margin: 0 auto;">
        </a>
        <div class="card-footer" style="padding: 0.5rem; text-align: center; background-color: #f8f9fa;">
            <a style="text-decoration: none; color: inherit;">
                Agregar Densidades
            </a>
        </div>
    </div>
    <!-- Modal Bootstrap para Densidades -->
    <div class="modal fade" id="densidadesModal" tabindex="-1" aria-labelledby="densidadesModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="densidadesModalLabel">Agregar Densidades (Captura)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí irán las áreas de captura -->
                    <div class="container">
                        <div class="row g-4">
                            <!-- Recuadro 1 -->
                            <div class="col-md-6">
                                <div class="clipboard-box text-center paste-zone" id="pasteZone1" data-index="1"
                                    contenteditable="true">
                                    @if ($screenshot1)
                                        <div class="preview-wrapper">
                                            <img src="{{ $screenshot1 }}" class="img-preview" />
                                        </div>
                                    @else
                                        <i class="fas fa-paste fa-3x mb-2 text-muted"></i>
                                        <p class="mb-0"><strong>Captura 1</strong></p>
                                        <small class="text-muted">Haz clic aquí y luego presiona Ctrl + V</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Recuadro 2 -->
                            <div class="col-md-6">
                                <div class="clipboard-box text-center paste-zone" id="pasteZone2" data-index="2"
                                    contenteditable="true">
                                    @if ($screenshot2)
                                        <div class="preview-wrapper">
                                            <img src="{{ $screenshot2 }}" class="img-preview" />
                                        </div>
                                    @else
                                        <i class="fas fa-paste fa-3x mb-2 text-muted"></i>
                                        <p class="mb-0"><strong>Captura 2</strong></p>
                                        <small class="text-muted">Haz clic aquí y luego presiona Ctrl + V</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="savePdf">
                        <i class="fas fa-save"></i> Guardar PDF
                    </button>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addCaptureCard = document.getElementById('addCapture');
            addCaptureCard.addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('densidadesModal'));
                modal.show();
            });

            document.querySelectorAll('.paste-zone').forEach(zone => {
                zone.addEventListener('paste', function(e) {
                    const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                    for (const item of items) {
                        if (item.type.indexOf('image') !== -1) {
                            const file = item.getAsFile();
                            const reader = new FileReader();
                            const index = zone.dataset.index;

                            reader.onload = function(event) {
                                Livewire.emit('screenshotPasted', index, event.target.result);
                            };

                            reader.readAsDataURL(file);
                            e.preventDefault();
                        }
                    }
                });
            });
            window.addEventListener('pdfReady', e => {
                window.open(e.detail, '_blank');
            });

            window.addEventListener('swal:alert', e => {
                Swal.fire({
                    title: e.detail.title,
                    text: e.detail.text,
                    icon: e.detail.icon,
                    confirmButtonText: 'Aceptar'
                });
            });
        });
    </script>
</div>
