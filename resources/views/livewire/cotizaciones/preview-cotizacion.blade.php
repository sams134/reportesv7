<div>

    <x-pretty-card>

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div>

                <a href="{{ route('admin.cotizaciones.index') }}" class="btn btn-sm btn-outline-secondary mb-3">

                    <i class="fas fa-arrow-left me-1"></i>
                    Volver a cotizaciones

                </a>

                <h2 class="mb-1">
                    {{ $cotizacion->numero }}
                </h2>

                <div class="text-muted">
                    Vista previa de cotización
                </div>

            </div>
            <div class="d-flex align-items-center gap-2">

                <a href="{{ route('admin.cotizaciones.edit', [
                    'cotizacion' => $cotizacion->id,
                ]) }}"
                    class="btn btn-outline-primary">

                    <i class="fas fa-edit me-1"></i>
                    Editar cotización

                </a>


                <button type="button" class="btn btn-danger" wire:click="abrirModalOpcionesPdf">

                    <i class="far fa-file-pdf me-1"></i>
                    Generar PDF

                </button>

            </div>

            <div class="text-end">

                <span class="badge bg-primary">
                    Versión {{ $cotizacion->version }}
                </span>

            </div>

        </div>

    </x-pretty-card>
    <div class="card shadow-sm mb-3">

        <div class="card-header bg-light d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">
                    Vista previa del documento
                </div>

                <div class="small text-muted">
                    Esta vista utiliza la misma plantilla del PDF, pero se genera directamente en HTML.
                </div>
            </div>

            <div class="badge bg-success">
                Preview HTML
            </div>

        </div>


        <div class="card-body p-0">

            <div wire:ignore>

                <iframe
                    src="{{ route('admin.cotizaciones.previewHtml', [
                        'cotizacion' => $cotizacion->id,
                        'portada' => 1,
                        'carta' => 1,
                        'iva' => 1,
                    ]) }}"
                    style="
                    display: block;
                    width: 100%;
                    height: calc(100vh - 220px);
                    min-height: 900px;
                    border: 0;
                    background: #ffffff;
                "
                    title="Vista previa {{ $cotizacion->numero }}">
                </iframe>

            </div>

        </div>

    </div>


@include('livewire.cotizaciones.partials.opciones-pdf-cotizacion', [
    'contextoPdf' => 'preview'
])
</div>
