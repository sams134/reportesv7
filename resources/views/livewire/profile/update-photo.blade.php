<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="card p-3" style="max-width:220px">
                    <div class="avatar avatar-5xl mb-3">
                        @if ($hasProfilePhoto && $avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $name }}" class="rounded-circle img-thumbnail"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white fw-bold shadow-sm"
                                style="width: 120px; height: 120px; font-size: 38px;">
                                {{ $avatarInitials }}
                            </div>
                        @endif
                    </div>
                </div>
                @error('general')
                    <div class="alert alert-danger mt-3">
                        {{ $message }}
                    </div>
                @enderror

            </div>
            <div class="mt-2">
                <button class="btn btn-falcon-primary me-1 mb-1" type="button"
                    onclick="document.querySelector('#imagenBtn').click()" wire:loading.attr="disabled"
                    wire:target="photo">
                    <span wire:loading.remove wire:target="photo">
                        Cambiar foto
                    </span>

                    <span wire:loading wire:target="photo">
                        Cargando foto...
                    </span>
                </button>

                <input type="file" id="imagenBtn" wire:model="photo" accept="image/*" style="display: none;">

                <div wire:loading wire:target="photo" class="text-primary small mt-2">
                    Subiendo y procesando imagen...
                </div>

                @error('photo')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror

                @if ($photoMessage)
                    <div class="text-success small mt-2">
                        {{ $photoMessage }}
                    </div>
                @endif
            </div>

        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Permisos del usuario</h5>
                            <small>Herramientas disponibles según el tipo de usuario</small>
                        </div>

                        <span class="badge bg-light text-primary">
                            {{ $roleName }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if (!empty($roleTools))
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Acción / Herramienta</th>
                                        <th style="width: 120px;" class="text-center">Estado</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($roleTools as $index => $tool)
                                        <tr>
                                            <td class="text-muted">
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $tool }}
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    Permitido
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            Este usuario no tiene herramientas asignadas.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="w-md-75">
        <!-- Name -->
        <div class="mb-3">
            <x-jet-label for="name" value="Nombre" />
            <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                wire:model.defer="name" autocomplete="name" />
            <x-jet-input-error for="name" />
        </div>

        <!-- Email -->
        <div class="mb-3">
            <x-jet-label for="email" value="Email" />
            <x-jet-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                wire:model.defer="email" />
            <x-jet-input-error for="email" />
        </div>

        <!-- Telefono -->
        <div class="mb-3">
            <x-jet-label for="telefono" value="Telefono" />
            <x-jet-input id="phone" type="text" class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                wire:model.defer="phone" />
            <x-jet-input-error for="phone" />
        </div>
        <!-- Direccion -->
        <div class="mb-3">
            <x-jet-label for="direccion" value="Direccion domicilio" />
            <x-jet-input id="direccion" type="text" class="{{ $errors->has('direccion') ? 'is-invalid' : '' }}"
                wire:model.defer="direccion" />
            <x-jet-input-error for="direccion" />
        </div>
    </div>

    <div class="text-right" style="width: 100%;text-align: right">
        <x-jet-button wire:click="updateProfile" wire:loading.attr="disabled" wire:target="updateProfile">
            <div wire:loading wire:target="updateProfile" class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>

            Actualizar Información
        </x-jet-button>
    </div>
    @push('livescripts')
        <script>
            Livewire.on('userUpdated', function() {


                Swal.fire({
                    title: "Usuario Actualizado",
                    text: "La informacion del usuario se ha actualizado correctamente",
                    icon: "success"
                });
            })
        </script>
    @endpush
</div>
