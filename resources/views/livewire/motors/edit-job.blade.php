<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    {{ $job->fullos }}
    <x-page-title>
        <x-slot:title>Editar trabajo {{ $job->fullOs }} <br>
            <small>
                <a href="{{ route('motores.show', $job->motor) }}">{{ $job->motor->fullos }}</a>
            </small>
        </x-slot:title>
        Edite los datos del trabajo.
    </x-page-title>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Fotograf&iacute;a del Trabajo a Realizar </h5>

                </div>
                <div class="card-body">
                    <div class="row">

                        <img class="img-thumbnail"
                            src="{{ $photo ? $photo->temporaryUrl() : asset('storage' . $job->images->first()->image) }}"
                            alt="Foto Final" />


                        <button class="btn btn-falcon-primary me-1 mb-1 little-button" type="button"
                            onclick="document.getElementById('imagenBtn').click();">
                            <span><i class="fas fa-camera mx-1"></i> Cambiar Foto Principal</span></a>
                        </button>
                        <input type="file" id="imagenBtn" wire:model="photo" accept="image/*" style="display: none;">
                        @error('photo')
                            <div class="alert alert-danger my-1 py-1" role="alert">Es indispensable que ingrese una foto
                                del trabajo.</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Datos del Trabajo</h5>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="Tipo Trabajo">Seleccione el Tipo de Trabajo</label>
                            <select class="form-select" aria-label="Default select example"
                                wire:model="jobTypeSelected">
                                <option selected="">Seleccione un trabajo</option>
                                @foreach ($jobTypes as $jobType)
                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                    @if ($jobTypeSelected)
                        <div class="row">
                            <div class="col-5">
                                <div class="input-group mb-3"><span class="input-group-text"
                                        id="basic-addon1">{{ $jobRecord->prefix }}-</span>
                                    <input class="form-control" type="text" wire:model="year" readonly />
                                    @error('year')
                                        <div class="alert alert-danger my-1 py-1" role="alert"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>-
                            <div class="col-6">
                                <div class="input-group mb-3"><span class="input-group-text" id="basic-addon1">OS</span>
                                    <input class="form-control" type="text" wire:model="jobos" readonly>
                                    @error('os')
                                        <div class="alert alert-danger my-1 py-1" role="alert"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="jobDescription">{{ $jobRecord->campo1 }}</label>
                                <input class="form-control" type="text" wire:model="value_campo1" />
                                @error('value_campo1')
                                    <div class="alert alert-danger my-1 py-1" role="alert"> Es necesario que ingrese esta
                                        informacion
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @if ($jobRecord->campo2)
                            <div class="row">
                                <div class="col-12">
                                    <label for="jobDescription">{{ $jobRecord->campo2 }}</label>
                                    <input class="form-control" type="text" wire:model="value_campo2" />
                                    @error('value_campo2')
                                        <div class="alert alert-danger my-1 py-1" role="alert">Es necesario que ingrese
                                            esta informacion</div>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            @if ($jobTypeSelected)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Asignar Trabajo</h5>
                        <div class="row">
                            @if ($usersToAsign->count() > 0)
                                @foreach ($usersToAsign as $user)
                                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 card my-3">
                                        <img src="{{ asset('storage/' . $user->foto) }}" style="max-width:90%;">
                                        <span style="width: 100%;font-size:18px;font-weight:bold;"
                                            class="text-center text-primary">{{ $user->name }}</span>
                                        <div
                                            class="form-check form-switch text-center d-flex justify-content-center align-items-center">
                                            <input class="form-check-input"
                                                id="flexSwitchCheckDefault-{{ $user->id }}" type="checkbox"
                                                style="transform: scale(1.5);" wire:model="tecnicoSelected"
                                                value="{{ $user->id }}" />

                                            <label class="form-check-label text-primary mx-3 mt-2"
                                                for="flexSwitchCheckDefault" style="font-size: 1.25rem;">Asignar</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @error('tecnicoSelected')
                                <div class="alert alert-danger my-1 py-1" role="alert">Es necesario que seleccione al
                                    menos un t&eacute;cnico para asignar el trabajo.</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <style>
        .card-gallery {
            height: 350px;
            overflow: hidden;
            padding: 2px;
        }

        .card-img-top {
            height: 200px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            /* Mantiene la proporción y muestra letterboxing si es necesario */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Agregar mas fotos</h5>
                    <div class="row">
                        @if ($job->images->count() > 1)

                            <div class="row">
                                @foreach ($job->images->skip(1) as $foto)
                                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                                        <div class="card card-gallery">
                                            <img class="card-img-top" src="{{ asset('storage' . $foto->image) }}"
                                                alt="Foto"
                                                ondblclick="openImageModal('{{ asset('storage' . $foto->image) }}')">
                                            <div class="card-footer">
                                                <p class="card-text">{{ $foto->comentario }}</p>
                                                <p style="font-size: 12px" class="my-1">
                                                    <span class="fw-bold">Fecha Foto: </span>
                                                    {{ Carbon\Carbon::parse($foto->created_at)->format('d/m/Y') }}
                                                </p>

                                                @if ($foto->user)
                                                    <p style="font-size: 12px" class="my-1">
                                                        <span class="fw-bold">Foto Tomada por: </span>
                                                        {{ $foto->user->name }}
                                                    </p>
                                                    @if ($foto->user->id == auth()->user()->id || in_array(auth()->user()->userType, [1, 2]))
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="deleteImage({{$foto->id}})">Eliminar</button>
                                                        
                                                    @endif
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 text-end">
                <div class="card-body">
                    <button class="btn btn-falcon-danger" wire:click="cancel">Cancelar</button>
                    <button class="btn btn-falcon-primary" wire:click="saveJob"
                        {{ !$jobTypeSelected ? 'disabled' : '' }}>Actualizar Trabajo</button>
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">Hay errores en la creaci&oacute;n del trabajo.
                            Verifique...</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        deleteImage = function(id) {
            Swal.fire({
                title: '¿Está seguro de eliminar esta imagen?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteImage', id);
                }
            });
        }
        Livewire.on('jobUpdated', () => {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Trabajo Actualizado con éxito.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
</div>
