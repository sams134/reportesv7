 @php
     $contextoPdf = $contextoPdf ?? 'create';
     $esIndexPdf = $contextoPdf === 'index';
 @endphp
 <div wire:ignore.self class="modal fade" id="opcionesPdfCotizacionModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" style="max-width: 650px">
         <div class="modal-content position-relative">

             <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                 <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" type="button"
                     data-bs-dismiss="modal" aria-label="Close">
                 </button>
             </div>

             <div class="modal-body p-0">
                 <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                     <h4 class="mb-1">
                         Opciones para generar PDF
                     </h4>

                     <p class="mb-0 small text-muted">
                         Configure cómo desea generar la cotización antes de guardar y crear el PDF.
                     </p>
                 </div>

                 <div class="p-4 pb-0">
                     <div class="mb-3">
                         <label class="form-label">
                             Título de la cotización
                         </label>

                         <input type="text" class="form-control form-control-lg" wire:model.defer="tituloCotizacion"
                             placeholder="Oferta Presupuestaria" @if ($esIndexPdf) readonly @endif>

                         @error('tituloCotizacion')
                             <small class="text-danger">{{ $message }}</small>
                         @enderror

                         <div class="form-text">
                             Este título será guardado en la cotización y luego usado en el PDF.
                         </div>
                     </div>

                     <div class="mb-3">
                         <label class="form-label">
                             Subtítulo de la cotización
                         </label>

                         <input type="text" class="form-control" wire:model.defer="subtituloCotizacion"
                             placeholder="Resumen del tipo de cotización"
                             @if ($esIndexPdf) readonly @endif>

                         @error('subtituloCotizacion')
                             <small class="text-danger">{{ $message }}</small>
                         @enderror

                         <div class="form-text">
                             Puede usarse como resumen corto debajo del título principal.
                         </div>
                     </div>

                     <hr>

                     <div class="form-check form-switch mb-3">
                         <input class="form-check-input" type="checkbox" id="pdfUsarPortadaSwitch"
                             wire:model="pdfUsarPortada">

                         <label class="form-check-label" for="pdfUsarPortadaSwitch">
                             Agregar portada a la cotización
                         </label>
                     </div>
                     <div class="form-check form-switch mb-3">
                         <input class="form-check-input" type="checkbox" id="pdfUsarCartaPresentacionSwitch"
                             wire:model="pdfUsarCartaPresentacion">

                         <label class="form-check-label" for="pdfUsarCartaPresentacionSwitch">
                             Agregar carta de presentación
                         </label>
                     </div>
                     <div class="form-check form-switch mb-3">
                         <input class="form-check-input" type="checkbox" id="pdfMostrarDesgloseIvaSwitch"
                             wire:model="pdfMostrarDesgloseIva">

                         <label class="form-check-label" for="pdfMostrarDesgloseIvaSwitch">
                             Mostrar desglose de IVA
                         </label>

                         <div class="form-text">
                             Muestra el precio sin IVA y el valor correspondiente al IVA 12%.
                         </div>
                     </div>

                     <div class="alert alert-light border small mb-0">
                         Más adelante aquí agregaremos:
                         tipos de portada, carta de presentación, merge de cotizaciones,
                         términos y texto final.
                     </div>
                 </div>
             </div>

             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                     Cancelar
                 </button>

                 <button class="btn btn-danger" type="button" x-data="{ generandoPdf: false }"
                     x-on:click="
        generandoPdf = true;

        window.cotizacionPdfWindow = window.open('', '_blank');

        if (window.cotizacionPdfWindow) {
            window.cotizacionPdfWindow.document.write(`
                <html>
                    <head>
                        <title>Generando PDF...</title>
                        <style>
                            body {
                                font-family: Arial, Helvetica, sans-serif;
                                padding: 40px;
                                color: #222;
                            }
                        </style>
                    </head>
                    <body>
                        <h3>Generando PDF...</h3>
                        <p>Por favor espere.</p>
                    </body>
                </html>
            `);

            window.cotizacionPdfWindow.document.close();
        }

        const usarPortada = document.getElementById('pdfUsarPortadaSwitch')?.checked ? 1 : 0;
        const usarCartaPresentacion = document.getElementById('pdfUsarCartaPresentacionSwitch')?.checked ? 1 : 0;
        const mostrarDesgloseIva = document.getElementById('pdfMostrarDesgloseIvaSwitch')?.checked ? 1 : 0;

        $wire.generarPdfDesdeModal(usarPortada,usarCartaPresentacion,mostrarDesgloseIva);
        "
                     x-bind:disabled="generandoPdf" x-on:cotizacion-pdf-finalizado.window="generandoPdf = false">

                     <span x-show="!generandoPdf">
                         <i class="far fa-file-pdf me-1"></i>
                         @if ($esIndexPdf)
                             Generar PDF
                         @else
                             Guardar y generar PDF
                         @endif
                     </span>


                     <span x-show="generandoPdf">
                         <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                         Generando PDF...
                     </span>
                 </button>
                
             </div>
         </div>
     </div>
     <script>
         window.addEventListener('abrir-modal-opciones-pdf-cotizacion', function() {
             const modalElement = document.getElementById('opcionesPdfCotizacionModal');

             if (!modalElement) {
                 return;
             }

             const modal = new bootstrap.Modal(modalElement);
             modal.show();
         });
     </script>
     <script>
         window.addEventListener('cotizacion-pdf-listo', function(event) {
             const url = event.detail.url;

             const modalElement = document.getElementById('opcionesPdfCotizacionModal');

             if (modalElement) {
                 const modal = bootstrap.Modal.getInstance(modalElement);

                 if (modal) {
                     modal.hide();
                 }
             }

             if (window.cotizacionPdfWindow && !window.cotizacionPdfWindow.closed) {
                 window.cotizacionPdfWindow.location.href = url;
             } else {
                 window.open(url, '_blank');
             }

             window.dispatchEvent(new CustomEvent('cotizacion-pdf-finalizado'));
         });
     </script>
 </div>
