<div class="card">
    <div class="card-header">
        <h5>Información del perfil</h5>
    </div>

    <div class="card-body">
        <p>Actualize la información de su perfil y su dirección de correo electrónico.</p>

        @if ($errors->any())
            <div class="alert alert-success">
                {{ __('Saved.') }}
            </div>
        @endif

        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            @livewire('profile.update-photo')
        @endif
    </div>

    {{-- Uncomment and modify as needed --}}
    {{-- <div class="card-footer">
        <div class="d-flex align-items-baseline">
            <button class="btn btn-primary">
                <div wire:loading class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                {{ __('Save') }}
            </button>
        </div>
    </div> --}}
</div>
