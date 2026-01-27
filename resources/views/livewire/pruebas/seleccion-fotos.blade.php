<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <x-form-card title="Selección de fotos" class="mb-3">
        <div class="row">
            @foreach ($motor->fotos as $foto)
                <div class="col-12 col-xxl-6">
                    <div class="row card mb-3 ms-2">
                        <div class="d-flex">
                            <div class="col-5 p-1 d-flex" style="border:0;margin:5px;">
                                <div class="mb-1 col-6 p-0">
                                    <img class="card-img-top p-1" src="{{ asset('storage' . $foto->foto) }}"
                                        alt="Foto"
                                        style="width:250px;height:205px;object-fit:cover;border:1px solid #000">

                                    <button type="button" class="btn btn-danger mt-2"
                                        wire:click="$emit('confirmarBorrarFoto', {{ $foto->id }})">
                                        <i class="me-2 fa fa-trash"></i> Borrar foto
                                    </button>


                                </div>
                            </div>

                            <div class="col-7 p-1" style="margin:5px;">
                                <x-form-card title="Datos de la Fotografía">
                                    <div class="form-check">
                                        <input class="form-check-input" id="addToReport-{{ $foto->id }}"
                                            type="checkbox" {{-- marcado si addToReport == 1 --}} @checked($foto->addToReport)
                                            {{-- al clic, alterna en BD --}} wire:click="toggleAddToReport({{ $foto->id }})"
                                            {{-- opcional: deshabilita mientras procesa --}} wire:loading.attr="disabled"
                                            wire:target="toggleAddToReport({{ $foto->id }})" />
                                        <label class="form-check-label" for="addToReport-{{ $foto->id }}" >
                                            Agregar a Informe
                                        </label>
                                    </div>

                                    <select class="form-select mt-2" wire:model="fotoTipos.{{ $foto->id }}"
                                        wire:change="updateTipo({{ $foto->id }})">

                                        <option value="">(Tipo desconocido)</option>
                                        @foreach ($tipos_foto as $id => $nombre)
                                            <option value="{{ $id }}">{{ $nombre }}</option>
                                        @endforeach
                                    </select>

                                    <div class="mb-3">
                                        <label class="form-label" for="desc-{{ $foto->id }}">Descripcion</label>
                                        <textarea class="form-control" id="desc-{{ $foto->id }}" rows="3"
                                            wire:model.defer="titulos.{{ $foto->id }}" wire:change="saveTitulo({{ $foto->id }})" {{-- si prefieres que guarde apenas pierda foco en vez de change, puedes usar: --}}
                                            {{-- wire:blur="saveTitulo({{ $foto->id }})" --}}></textarea>
                                        <small class="text-muted" wire:loading
                                            wire:target="saveTitulo({{ $foto->id }})">
                                            Guardando…
                                        </small>
                                    </div>
                                </x-form-card>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>

    </x-form-card>
    @push('scripts')
        <script>
            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'hidden') {
                    Livewire.emit('saveAllTitulos');
                }
            });
            Livewire.on('confirmarBorrarFoto', fotoId => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('borrarFoto', fotoId);
                    }
                })
            });

            Livewire.on('fotoBorrada', () => {
                Swal.fire(
                    '¡Borrada!',
                    'La foto se eliminó correctamente.',
                    'success'
                )
            });
        </script>
    @endpush
</div>
