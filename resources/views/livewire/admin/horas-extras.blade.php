<div>
        <button class="btn btn-falcon-primary me-1 mb-1 little-button" class="btn btn-outline-primary me-1 mb-1" type="button" data-bs-toggle="modal"
        data-bs-target="#horas-extra-modal">
            <span><i class="fas fa-clock mx-1"></i> Horas Extra</span>
        </button>



    <div wire:ignore.self class="modal fade" id="horas-extra-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 70%">
            <div class="modal-content position-relative">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Agregar Horas Extra </h4>
                    </div>
                    <div class="p-4 pb-0">
                        
                                <x-pretty-card>
                                    @if($existing)
                                        <h3>Ya tienes horas extra en este dia</h3>
                                    
                                    @elseif (!$authorized)
                                        <h3 wire:poll.1000ms>{{ ucfirst(now()->locale('es')->isoFormat('dddd D [de] MMMM h:mm:ss A')) }}</h3>
                                        A esta hora no puedes crear horas extra
                                        @else
                                        <div class="row">
                                            <div class="col-12">
                                                
                                                <div class="table-responsive scrollbar">
                                                    <table class="table table-bordered overflow-hidden">
                                                      <colgroup>
                                                        <col class="bg-soft-primary" />
                                                        <col />
                                                      </colgroup>
                                                      <tbody>
                                                        <tr class="btn-reveal-trigger">
                                                          <td>Inicio</td>
                                                          <td>{{ ucfirst(\Carbon\Carbon::parse($init)->locale('es')->isoFormat('dddd D [de] MMMM h:mm:ss A')) }}</td>
                                                        </tr>
                                                        <tr class="btn-reveal-trigger">
                                                            <td>Fin</td>
                                                            <td wire:poll.1000ms>{{ ucfirst(now()->locale('es')->isoFormat('dddd D [de] MMMM h:mm:ss A')) }}</td>
                                                          </tr>
                                                          <tr class="btn-reveal-trigger">
                                                            <td>Cant Horas</td>
                                                            <td wire:poll.1000ms>
                                                                <small>
                                                                    {{ \Carbon\Carbon::parse($init)->diffInHours(now()) }} Horas
                                                                    {{ \Carbon\Carbon::parse($init)->diffInMinutes(now()) % 60 }} Minutos
                                                                </small>
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <i class="fas fa-clock"></i>&nbsp;&nbsp;Horas Extra
                                                                    </span>
                                                                    <input class="form-control" type="text" aria-label="Username" aria-describedby="basic-addon1" wire:model="hours"/>
                                                                </div>
                                                            </td>
                                                          </tr>
                                                          <tr class="btn-reveal-trigger">
                                                            <td>OS</td>
                                                            <td> {{$motor->fullos}}({{$motor->cliente->cliente}})
                                                            </td>
                                                          </tr>
                                                      </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlTextarea1">Descripcion de trabajo</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="description" ></textarea>
                                                  </div>
                                            </div>
                                        </div>

                                        
                                    @endif
                                </x-pretty-card>
                          
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    @if ($authorized)
                        <button class="btn btn-primary" wire:click.prevent="store()" type="button">Guardar</button>
                        
                    @endif
                   
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('livescripts')
    <script>
        Livewire.on('horas-extra-created', function() {

            const contactModal = bootstrap.Modal.getInstance(document.getElementById('horas-extra-modal'));
            contactModal.hide();
            Swal.fire({
                title: "Horas Extras Adicionadas",
                text: "Sus horas extra fueron cargadas a su planilla y a la orden de servicio",
                icon: "success"
            });
        })
    </script>
@endpush
