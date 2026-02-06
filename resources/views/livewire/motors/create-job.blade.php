<div>
    <x-page-title>
        <x-slot:title>Crear Nuevo Trabajo Mec&aacute;nico para OS: <a
                href="{{ route('motores.show', $motor) }}">{{ $motor->fullos }}</a></x-slot:title>
        Estos son trabajos cobrables a los clientes.
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
                            src="{{ $photo ? $photo->temporaryUrl() : asset('img/default-avatar.png') }}"
                            alt="Foto Final" />


                        <button class="btn btn-falcon-primary me-1 mb-1 little-button" type="button"
                            onclick="document.getElementById('imagenBtn').click();">
                            <span><i class="fas fa-camera mx-1"></i> Cambiar Foto</span></a>
                        </button>
                       
                        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true; progress = 0"
                            x-on:livewire-upload-finish="isUploading = false; progress = 100"
                            x-on:livewire-upload-error="isUploading = false; progress = 0"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            {{-- Input oculto --}}
                            <input type="file" id="imagenBtn" wire:model="photo" accept="image/*" class="d-none">

                            {{-- Barra de progreso --}}
                            <div x-show="isUploading" class="mt-2">
                                <div class="d-flex justify-content-between">
                                    <small>Subiendo imagen…</small>
                                    <small x-text="progress + '%'"></small>
                                </div>

                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" :style="`width: ${progress}%`"
                                        :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            {{-- Spinner mientras Livewire procesa --}}
                            <div wire:loading wire:target="photo" class="mt-1">
                                <small>Procesando imagen…</small>
                            </div>

                            @error('photo')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

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
                                                for="flexSwitchCheckDefault"
                                                style="font-size: 1.25rem;">Asignar</label>
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
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Agregar mas fotos</h5>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 text-end">
                <div class="card-body">
                    <button class="btn btn-falcon-danger" wire:click="cancel">Cancelar</button>
                    <button class="btn btn-falcon-primary" wire:click="saveJob" wire:loading.attr="disabled" wire:target="photo,saveJob"
                        {{ !$jobTypeSelected ? 'disabled' : '' }}>Guardar Trabajo</button>
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">Hay errores en la creaci&oacute;n del trabajo.
                            Verifique...</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
