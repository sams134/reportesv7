<!-- Botón para abrir el modal -->
<div>
   <button class="btn btn-success dropdown-toggle align-middle" style="height: 38px;"
        data-bs-toggle="modal"
        data-bs-target="#compartirModal_{{ $board->id }}">
    <i class="fas fa-plus me-1"></i> Compartir Con:
</button>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="compartirModal_{{ $board->id }}" tabindex="-1" aria-labelledby="compartirModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Compartir con otros usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <x-pretty-card>
                        <div class="table-responsive scrollbar" style="max-height: 60vh; overflow-y: auto;">
                            <h6>Selecciona los usuarios con los que deseas compartir</h6>
                            <table class="table table-hover">
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="width:70px">
                                            <img src="{{ asset('storage/' . $user->foto) }}" alt=""
                                                class="avatar" style="max-height: 80px; max-width: 50px;">
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="switchUser_{{ $user->id }}"
                                                    type="checkbox"
                                                    wire:model.defer="tecnicoSelected.{{ $user->id }}">
                                                <label class="form-check-label" for="switchUser_{{ $user->id }}">
                                                    {{ $user->name }}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </x-pretty-card>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="saveShared">
                        <i class="fas fa-share-square"></i> Compartir
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            // Evento emitido desde el componente Livewire
            window.addEventListener('close-compartir-modal', function(e) {
                const modalId = 'compartirModal_' + e.detail.id;
                const modalEl = document.getElementById(modalId);

                // Verifica si hay una instancia del modal
                let modal = bootstrap.Modal.getInstance(modalEl);

                // Si no existe, la crea (necesario cuando wire:ignore.self está activo)
                if (!modal) {
                    modal = new bootstrap.Modal(modalEl);
                }

                modal.hide();

                const users = e.detail.users;
                const board = e.detail.board;

                let message = '';
                if (users.length === 1) {
                    message =
                    `El tablero <b>${board}</b> fue compartido con el usuario <b>${users[0]}</b>.`;
                } else if (users.length > 1) {
                    const formattedUsers = users.map(u => `<b>${u}</b>`).join(', ');
                    message =
                        `El tablero <b>${board}</b> fue compartido con los usuarios: ${formattedUsers}.`;
                } else {
                    message = `No se seleccionó ningún usuario para compartir el tablero <b>${board}</b>.`;
                }

                Swal.fire({
                    title: '¡Tablero compartido!',
                    html: message,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            });

            Livewire.on('shared-error', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No tienes permisos para compartir este board.'
                });
            });
        });
    </script>
</div>
