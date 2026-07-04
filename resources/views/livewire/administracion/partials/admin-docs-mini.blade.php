@if (!empty($docs))
    <div class="d-flex align-items-center flex-wrap gap-1 mt-1">
        @foreach ($docs as $doc)
            <div class="d-inline-flex align-items-center border rounded bg-light overflow-hidden"
                style="max-width: 220px;" title="{{ $doc['archivo_original'] ?? ($doc['nombre'] ?? 'Documento') }}">
                <a href="{{ $doc['url'] }}" target="_blank"
                    class="d-inline-flex align-items-center text-decoration-none px-1 py-1" style="max-width: 180px;">
                    @if ($doc['es_imagen'])
                        <img src="{{ $doc['url'] }}" class="rounded border me-1"
                            style="width:25px; height:25px; object-fit:cover;">
                    @elseif ($doc['es_pdf'])
                        <span
                            class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded me-1"
                            style="width:25px; height:25px;">
                            <i class="far fa-file-pdf" style="font-size:13px;"></i>
                        </span>
                    @else
                        <span
                            class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded me-1"
                            style="width:25px; height:25px;">
                            <i class="far fa-file" style="font-size:13px;"></i>
                        </span>
                    @endif

                    <span class="small text-truncate" style="max-width:120px;">
                        {{ $doc['nombre'] ?? ($doc['archivo_original'] ?? 'Documento') }}
                    </span>
                </a>

                <button type="button" class="btn btn-sm btn-link text-danger px-2 py-1 admin-doc-delete-btn"
                    wire:click.stop="confirmarEliminarInfoDocumento({{ $doc['id'] }})" title="Eliminar documento">
                    <i class="fas fa-trash" style="font-size:12px;"></i>
                </button>
            </div>
        @endforeach
    </div>
@endif
