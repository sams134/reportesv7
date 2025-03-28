<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="row">
        <div class="card p-3" style="max-width:220px">
            <img src="{{!$photo?(Auth::user()->foto?asset('storage/' .Auth::user()->foto):$this->user->profile_photo_url):$photo->temporaryUrl()}}"  alt="..." style="max-width:200px">
        </div>
    </div>
    <div class="mt-2">
        <button class="btn btn-falcon-primary me-1 mb-1" type="button" onclick="document.querySelector('#imagenBtn').click()">Cambiar foto</button>
        <input type="file" id="imagenBtn" wire:model="photo" accept="image/*" 
        style="display: none;">
    </div>

    <div class="w-md-75">
        <!-- Name -->
        <div class="mb-3">
            <x-jet-label for="name" value="Nombre" />
            <x-jet-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" wire:model.defer="name" autocomplete="name" />
            <x-jet-input-error for="name" />
        </div>

        <!-- Email -->
        <div class="mb-3">
            <x-jet-label for="email" value="Email" />
            <x-jet-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" wire:model.defer="email" />
            <x-jet-input-error for="email" />
        </div>

         <!-- Telefono -->
         <div class="mb-3">
            <x-jet-label for="telefono" value="Telefono" />
            <x-jet-input id="phone" type="text" class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" wire:model.defer="phone" />
            <x-jet-input-error for="phone" />
        </div>
        <!-- Direccion -->
        <div class="mb-3">
            <x-jet-label for="direccion" value="Direccion domicilio" />
            <x-jet-input id="direccion" type="text" class="{{ $errors->has('direccion') ? 'is-invalid' : '' }}" wire:model.defer="direccion" />
            <x-jet-input-error for="direccion" />
        </div>
    </div>
   
    <div class="text-right" style="width: 100%;text-align: right">
        <x-jet-button wire:click="updateProfile">
            <div wire:loading class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>

            Actualizar Informacion
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
