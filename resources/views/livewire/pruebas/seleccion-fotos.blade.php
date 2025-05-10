<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <x-form-card title="Selección de fotos" class="mb-3">
        <div class="row">
            @foreach ($motor->fotos as $foto)
                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <img class="card-img-top p-3" src="{{ asset('storage' . $foto->foto) }}"
                                            alt="Foto" style="width: 100% ">
                        
                    </div>
                </div>
            @endforeach
            <div class="col-12 col-md-6">
               
            </div>
        </div>
        
    </x-form-card>
</div>
