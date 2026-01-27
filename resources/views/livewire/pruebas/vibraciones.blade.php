<div>
    <x-form-card title="Cargar PDFs de Vibraciones">

        <input type="file" id="vibracionesPdfInput" accept="application/pdf" wire:model="doc" hidden>

        <div class="d-flex flex-wrap gap-3">

            {{-- Card para subir --}}
            <div class="card document-card"
                 style="width: 200px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; cursor:pointer;"
                 onclick="document.getElementById('vibracionesPdfInput').click()">
                <img src="{{ asset('img/pdfadd.png') }}" alt="Agregar PDF" title="Agregar PDF"
                     style="width: 50%; display: block; margin: 12px auto;">
                <div class="card-footer" style="padding: 0.5rem; text-align: center; background-color: #f8f9fa;">
                    <span style="text-decoration: none; color: inherit;">Agregar PDF Vibraciones</span>
                </div>
            </div>

            {{-- Loading robusto (sin wire:loading) --}}
            @if($doc)
                <div class="d-flex align-items-center" style="height: 200px;">
                    <span class="text-muted">Subiendo PDF...</span>
                </div>
            @endif

            {{-- Gallery --}}
            @foreach ($docsVibraciones as $d)
                <div class="card document-card"
                     style="width: 220px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                    <a href="{{ asset('storage' . $d->documento) }}" target="_blank" style="text-decoration:none;">
                        <img src="{{ asset('img/pdflogo.png') }}" alt="PDF"
                             style="width: 45%; display: block; margin: 12px auto;">
                    </a>

                    <div class="card-body" style="padding: 0.6rem;">
                        <div style="font-size: 13px; font-weight: 600; word-break: break-word;">
                            {{ $d->titulo ?? 'PDF Vibraciones' }}
                        </div>
                        <div class="text-muted" style="font-size: 11px;">
                            {{ optional($d->created_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center"
                         style="padding: 0.5rem; background-color: #f8f9fa;">
                        <a class="btn btn-sm btn-outline-primary"
                           href="{{ asset('storage' . $d->documento) }}" target="_blank">
                            Ver
                        </a>

                        <button class="btn btn-sm btn-outline-danger" type="button"
                                wire:click="deleteDoc({{ $d->id }})"
                                onclick="return confirm('¿Eliminar este PDF?')">
                            Eliminar
                        </button>
                    </div>
                </div>
            @endforeach

            @if ($docsVibraciones->count() === 0)
                <div class="text-muted" style="align-self:center;">
                    No hay PDFs de vibraciones cargados aún.
                </div>
            @endif

        </div>

        @error('doc')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror

    </x-form-card>
</div>

