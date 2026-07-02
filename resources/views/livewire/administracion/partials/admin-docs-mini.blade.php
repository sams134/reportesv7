@if (!empty($docs))
    <div class="d-flex align-items-center flex-wrap gap-1 mt-1">
        @foreach ($docs as $doc)
            <a
                href="{{ $doc['url'] }}"
                target="_blank"
                class="d-inline-flex align-items-center text-decoration-none border rounded px-1 py-1 bg-light"
                style="max-width: 180px;"
                title="{{ $doc['archivo_original'] }}"
            >
                @if ($doc['es_imagen'])
                    <img
                        src="{{ $doc['url'] }}"
                        class="rounded border me-1"
                        style="width:25px; height:25px; object-fit:cover;"
                    >
                @elseif ($doc['es_pdf'])
                    <span
                        class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded me-1"
                        style="width:25px; height:25px;"
                    >
                        <i class="far fa-file-pdf" style="font-size:13px;"></i>
                    </span>
                @else
                    <span
                        class="d-inline-flex align-items-center justify-content-center bg-secondary text-white rounded me-1"
                        style="width:25px; height:25px;"
                    >
                        <i class="far fa-file" style="font-size:13px;"></i>
                    </span>
                @endif

                <span class="small text-truncate" style="max-width:130px;">
                    {{ $doc['nombre'] }}
                </span>
            </a>
        @endforeach
    </div>
@endif